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
        $this->voted = false; // This will check if the user has already voted.
    }

    public function selectOption($optionId)
    {
        $this->selectedOption = $optionId;
    }

    public function vote()
    {
        if (!$this->voted && $this->selectedOption) {
            $option = PollOption::findOrFail($this->selectedOption);
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
