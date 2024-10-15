<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\Cookie;

class PollPreview extends Component
{
    public Poll $poll;
    public ?int $selectedOption = null;
    public bool $voted = false;

    public function mount()
    {
        $cookieKey = 'poll_' . $this->poll->id . '_v' . $this->poll->version;
        $this->voted = Cookie::has($cookieKey);
    }

    public function selectOption($optionId)
    {
        $this->selectedOption = $optionId;
    }

    public function vote()
    {
        if (!$this->voted) {
            $option = PollOption::find($this->selectedOption);
            $option->increment('votes');
            $this->voted = true;

            $cookieKey = 'poll_' . $this->poll->id . '_v' . $this->poll->version;
            Cookie::queue(Cookie::make($cookieKey, true, 1440)); // 24 hours
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
