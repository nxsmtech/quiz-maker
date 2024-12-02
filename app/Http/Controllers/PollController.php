<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\View\View;

class PollController extends Controller
{
    public function show(Poll $poll): ?View
    {
        return view('components.poll-preview', ['poll' => $poll]);
    }
}
