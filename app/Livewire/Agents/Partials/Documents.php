<?php

namespace App\Livewire\Agents\Partials;

use App\Models\AgentFile;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Documents extends Component
{
    public $agent_id;

    public function mount($agent_id)
    {
        $this->agent_id = $agent_id;
    }

    #[Computed]
    public function documents()
    {
        $docs = AgentFile::with('agent')
            ->where('agent_id', $this->agent_id)
            ->get();
        $docs = $docs->filter(function ($doc) {
            return $doc->type !== 'url';
        });

        return $docs;
    }

    #[On('document_deleted')]
    #[On('document_updated')]
    public function index()
    {
        $this->documents();
    }

    public function render()
    {
        return view('livewire.agents.partials.documents');
    }
}
