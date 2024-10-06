@extends('layouts.app')

@section('content')
    <div>
        @livewire('quiz-preview', ['quiz' => $quiz])
    </div>
@endsection
