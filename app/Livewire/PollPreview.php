<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Poll;
use App\Models\PollOption;

class PollPreview extends Component
{
    public Poll $poll;
    public ?int $selectedOption = null;
    public bool $voted = false;

    public function mount()
    {
        $this->voted = false;
    }

    public function selectOption($optionId)
    {
        $this->selectedOption = $optionId;
    }

    public function refreshPoll()
    {
        $this->poll->load('options'); // Reload related options with updated vote counts
    }

    public function vote($selectedOption)
    {
        if (!$this->voted && $selectedOption) {
            $option = PollOption::findOrFail($selectedOption);
            $option->increment('votes');
            $this->voted = true;
        }
    }

    public function render()
    {
        return view('livewire.poll-preview', [
            'poll' => $this->poll,
            'totalVotes' => $this->poll->options->sum('votes'),
        ]);
    }
}
