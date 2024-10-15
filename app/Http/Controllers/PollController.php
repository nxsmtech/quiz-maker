<?php

namespace App\Http\Controllers;

use App\Models\Poll;

class PollController extends Controller
{
    public function show(Poll $poll)
    {
        return view('components.poll-preview', ['poll' => $poll]);
    }
}
