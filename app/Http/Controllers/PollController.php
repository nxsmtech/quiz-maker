<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\View\View;

class PollController extends Controller
{
    public function show(Poll $poll): ?View
    {
        if (!$poll->is_active) {
            return null;
        }

        return view('components.poll-preview', ['poll' => $poll]);
    }
}
