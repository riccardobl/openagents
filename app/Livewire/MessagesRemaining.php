<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class MessagesRemaining extends Component
{
    public $remaining = 0;

    public function mount()
    {
        $this->calculateRemainingMessages();
    }

    protected function calculateRemainingMessages()
    {
        $messagesToday = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $messagesToday = Message::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->whereNotNull('model')
                ->whereNull('agent_id')
                ->count();

            if ($user->isPro()) {
                // Assuming there's a method to check if the user is a Pro user
                $this->remaining = max(0, 100 - $messagesToday);
            } else {
                // Authenticated free user
                $this->remaining = max(0, 10 - $messagesToday);
            }
        } else {
            // Guest user
            $sessionId = Session::getId();
            $messagesToday = Message::where('session_id', $sessionId)
                ->whereDate('created_at', today())
                ->whereNotNull('model')
                ->whereNull('agent_id')
                ->count();
            $this->remaining = max(0, 5 - $messagesToday);
        }

        if ($this->remaining === 0) {
            $this->dispatch('no-more-messages');
        }
    }

    #[On('message-created')]
    public function updateStuff()
    {
        $this->calculateRemainingMessages();
    }

    public function render()
    {
        return view('livewire.messages-remaining');
    }
}
