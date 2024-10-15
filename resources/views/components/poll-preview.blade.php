@extends('layouts.app')

@section('content')
    <div>
        @livewire('poll-preview', ['poll' => $poll])
    </div>
@endsection
