<?php

namespace App\Livewire;

use App\AI\GreptileGateway;
use App\AI\NostrInference;
use App\AI\NostrRag;
use App\AI\SimpleInferencer;
use App\Models\Agent;
use App\Models\AgentFile;
use App\Models\Codebase;
use App\Models\NostrJob;
use App\Models\Thread;
use App\Services\ImageService;
use App\Services\NostrService;
use App\Traits\SelectedModelOrAgentTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Chat extends Component
{
    use SelectedModelOrAgentTrait, WithFileUploads;

    public $images = [];

    public $images_to_upload = [];

    public $showNoMoreMessages = false;

    public $waitingForStream = false;

    // Whether to show the "no more messages" message
    public $message_input = '';

    public $input = '';

    // User input from chat form
    public Thread $thread;

    // The saved input
    public $messages = [];

    // The thread we're chatting in
    public $pending = false;

    public function mount($id = null)
    {
        if (request()->query('model')) {
            session()->put('selectedModel', request()->query('model'));
        }

        if (request()->query('agent')) {
            session()->put('selectedAgent', request()->query('agent'));
            $agent = Agent::find(request()->query('agent'));
            if ($agent) {
                $this->pending = $agent->is_rag_ready;
                $this->selectedAgent = $this->getSelectedAgentArray($agent);
            }
        }

        // If ID is not null, we're in a thread. But if thread doesn't exist or doesn't belong to the user and doesn't match the session ID, redirect to homepage.
        if ($id) {
            $thread = Thread::find($id);
            if (! $thread || (auth()->check() && $thread->user_id !== auth()->id()) || (! auth()->check() && $thread->session_id !== session()->getId())) {
                return $this->redirect('/', true);
            } else {
                // Notify the sidebar component of the active thread
                $this->dispatch('active-thread', $id);
            }
        } else {
            $this->ensureThread();

            return;
        }

        // Set the thread and its messages
        $this->thread = $thread;
        $messages = $this->thread->messages()
            ->with('agent') // fetch the agent relationship
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        $this->messages = $messages;

        $this->setModelOrAgentForThread($this->thread);
    }

    private function ensureThread()
    {
        if (empty($this->thread)) {
            // Check if the user or guest has a recent thread with no messages
            $recentThread = null;

            if (auth()->check()) {
                $recentThread = Thread::where('user_id', auth()->id())
                    ->whereDoesntHave('messages')
                    // and where the agent_id is the current agent
                    ->where('agent_id', '===', $this->selectedAgent['id'] ?? 0)
                    ->latest()
                    ->first();
            } else {
                $recentThread = Thread::where('session_id', Session::getId())
                    ->whereDoesntHave('messages')
//                    ->where('agent_id', '===', $this->selectedAgent['id'] ?? 0)
                    ->latest()
                    ->first();
                dd($recentThread);
            }

            if ($recentThread) {
                $this->thread = $recentThread;
                $this->dispatch('thread-update');

                return $this->redirect('/chat/'.$this->thread->id, true);
            }

            // If no recent thread found, create a new one
            $data = [
                'title' => 'New chat',
                'session_id' => auth()->check() ? null : Session::getId(),
            ];

            if (auth()->check()) {
                $data['user_id'] = auth()->id();
            }

            // If selected agent, set agent_id
            if ($this->selectedAgent) {
                $data['agent_id'] = $this->selectedAgent['id'];
            }

            $thread = Thread::create($data);
            $this->thread = $thread;
            $this->dispatch('thread-update');

            return $this->redirect('/chat/'.$this->thread->id, true);
        }
    }

    #[On('select-agent')]
    public function selectAgent($agentId)
    {
        $agent = Agent::find($agentId);
        if ($agent) {
            $this->selectedAgent = [
                'id' => $agent->id,
                'name' => $agent->name,
                'description' => $agent->about,
                'instructions' => $agent->prompt,
                'image' => $agent->image_url,
            ];
            $this->selectedModel = '';
        } else {
            dd('Agent not found');
            $this->selectedAgent = null;
        }

        // If the agent has Codebase capability, fetch the codebases
        if ($agent->hasCapability('codebase_search')) {
            // Dispatch an event to notify the sidebar component of the active agent & selected codebases
            $this->dispatch('codebase-agent-selected', $agent->id);
        }
    }

    #[On('no-more-messages')]
    public function noMoreMessages()
    {
        // Redirect to homepage
        $this->showNoMoreMessages = true;
    }

    public function sendMessage(): void
    {
        // Save this input even after we clear the form this variable is tied to
        $this->input = $this->message_input;
        $this->images_to_upload = $this->images;

        // Append the message to the chat
        $this->messages[] = [
            'body' => $this->input,
            'sender' => 'You',
            'user_id' => auth()->id(), // Add user_id if logged in
            'session_id' => auth()->check() ? null : Session::getId(), // Add session_id if not logged in
            'agent_id' => $this->selectedAgent['id'] ?? null,
        ];

        // Clear the input
        $this->message_input = '';
        $this->pending = true;
        $this->images = [];

        // Call simpleRun after the next render
        $this->dispatch('message-created');
        if (! $this->selectedAgent) {
            $this->js('$wire.simpleRun()');
        } else {
            // $this->js('$wire.ragRun()');
            $this->js('$wire.runAgentWithoutRag()');
        }
    }

    public function runAgentWithoutRag()
    {
        // Attach any context necessary from querying the codebase
        $this->handleCodebaseContext();

        // Until RAG is working we'll just pass the agent info to the model
        $user_input = $this->input;
        $this->input = "You are an AI agent on OpenAgents.com. \n\n Your name is {$this->selectedAgent['name']}. \n\n Your description is: {$this->selectedAgent['description']}. \n\n Your instructions are: {$this->selectedAgent['instructions']}. \n\n Respond to the following user input: \"$user_input\"";

        // Convert any images to messages with descriptions generated by vision LLM
        $this->handleImageInput();

        // Authenticate user session or proceed without it
        $sessionId = auth()->check() ? null : Session::getId();

        // Save user message to the thread
        $this->thread->messages()->create([
            'body' => $user_input,
            'session_id' => $sessionId,
            'user_id' => auth()->id() ?? null,
        ]);

        // Simply do it
        $output = SimpleInferencer::inference($this->input, 'command-r-plus', $this->thread, $this->getStreamingCallback());

        // Append the response to the chat
        $message = [
            'agent_id' => $this->selectedAgent['id'],
            'body' => $output['content'],
            'model' => $this->selectedModel,
            'user_id' => auth()->id() ?? null,
            'session_id' => $sessionId,
            'agent' => $this->selectedAgent,
        ];
        $this->messages[] = $message;

        // Save the agent's response to the thread
        $this->thread->messages()->create(array_merge($message, [
            'input_tokens' => $output['input_tokens'],
            'output_tokens' => $output['output_tokens'],
        ]));

        // Reset pending status and scroll to the latest message
        $this->pending = false;

        // Optionally notify other components of the new message
        $this->dispatch('message-created');
    }

    public function handleCodebaseContext()
    {
        // If we're not in env local, return
        if (app()->environment() !== 'local') {
            return;
        }

        // Return if text does not include the word 'index'
        //        if (strpos($this->input, 'index') === false) {
        //            return;
        //        }

        $client = new GreptileGateway();
        $results = $client->search($this->input, Codebase::all());

        $this->input .= "\n\n"."Use these code results as context:\n".$results;
    }

    private function handleImageInput()
    {
        if (! empty($this->images_to_upload)) {
            $imageService = new ImageService();
            foreach ($this->images_to_upload as $image) {
                $imageService->addImageToThread($image, $this->thread);
            }
            $this->images_to_upload = [];
        }
    }

    private function getStreamingCallback()
    {
        return function ($response) {
            $token = $response['choices'][0]['delta']['content'] ?? '';
            $this->stream(
                to: 'streamtext'.$this->thread->id,
                content: $token
            );
        };
    }

    public function simpleRun()
    {
        // Convert any images to messages with descriptions generated by vision LLM
        $this->handleImageInput();

        // Authenticate user session or proceed without it
        $sessionId = auth()->check() ? null : Session::getId();

        // Save user message to the thread
        $this->thread->messages()->create([
            'body' => $this->input,
            'session_id' => $sessionId,
            'user_id' => auth()->id() ?? null,
        ]);

        // Simply do it
        $output = SimpleInferencer::inference($this->input, $this->selectedModel, $this->thread, $this->getStreamingCallback());

        // Append the response to the chat
        $message = [
            'body' => $output['content'],
            'model' => $this->selectedModel,
            'user_id' => auth()->id() ?? null,
            'session_id' => $sessionId,
        ];
        $this->messages[] = $message;

        // Save the agent's response to the thread
        $this->thread->messages()->create(array_merge($message, [
            'input_tokens' => $output['input_tokens'],
            'output_tokens' => $output['output_tokens'],
        ]));

        // Reset pending status and scroll to the latest message
        $this->pending = false;

        // Optionally notify other components of the new message
        $this->dispatch('message-created');
    }

    public function ragRun()
    {

        try {
            $sessionId = auth()->check() ? null : Session::getId();

            // Save user message to the thread
            $this->thread->messages()->create([
                'body' => $this->input,
                'session_id' => $sessionId,
                'user_id' => auth()->id() ?? null,
                'agent_id' => $this->selectedAgent['id'] ? $this->selectedAgent['id'] : null,
            ]);

            $nostrRag = new NostrRag(); // Generate history
            $query = $nostrRag->history($this->thread)->summary();

            $documents = AgentFile::where('agent_id', $this->selectedAgent['id'])->pluck('url')->toArray();

            // send to nostra

            $pool = config('nostr.pool');
            $encrypt = config('nostr.encrypt');

            $job_id = (new NostrService())
                ->poolAddress($pool)
                ->query($query)
                ->documents($documents)
                ->k(1)
                ->maxTokens(2048)
                ->overlap(256)
                ->warmUp(false)
                ->cacheDurationhint('-1')
                ->encryptFor($encrypt)
                ->execute();

            // Save to DB
            $nostr_job = new NostrJob();
            $nostr_job->agent_id = $this->selectedAgent['id'];
            $nostr_job->job_id = $job_id;
            $nostr_job->status = 'pending';
            $nostr_job->thread_id = $this->thread->id;
            $nostr_job->save();

        } catch (Exception $e) {
            Log::error($e);
        }

    }

    #[On('echo:threads.{thread.id},NostrJobReady')]
    public function process_nostr($event)
    {

        $this->selectedModel = 'mistral-small-latest';
        // Authenticate user session or proceed without it
        $sessionId = auth()->check() ? null : Session::getId();

        $job = NostrJob::where('thread_id', $this->thread->id)->find($event['id']);

        // Simply do it
        $output = NostrInference::inference($this->selectedModel, $job, $this->getStreamingCallback());

        // Append the response to the chat
        $this->messages[] = [
            'body' => $output['content'],
            'model' => $this->selectedModel,
            'user_id' => auth()->id() ?? null,
            'session_id' => $sessionId,
        ];

        // Save the agent's response to the thread
        $this->thread->messages()->create([
            'body' => $output['content'],
            'session_id' => $sessionId,
            'model' => $this->selectedModel,
            'user_id' => auth()->id() ?? null,
            'agent_id' => $this->selectedAgent ? $this->selectedAgent['id'] : null,
            'input_tokens' => $output['input_tokens'],
            'output_tokens' => $output['output_tokens'],
        ]);

        // Reset pending status and scroll to the latest message
        $this->pending = false;

        // Optionally notify other components of the new message
        $this->dispatch('message-created');
    }

    public function render()
    {
        return view('livewire.chat');
    }

    //    #[On('echo:agent_jobs.{selectedAgent.id},AgentRagReady')] // ??
    //    public function process_agent_rag($event)
    //    {
    //        $agent = Agent::find($event['agent_id']);
    //        if ($agent) {
    //            if ($this->selectedAgent['id'] == $agent->id && $agent->is_rag_ready) {
    //                $this->pending = false;
    //            }
    //        }
    //    }

}
