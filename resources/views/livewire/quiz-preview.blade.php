<div class="max-w-3xl mx-auto my-8 bg-white p-8 rounded-lg shadow-lg">
    @if(!$started)
        <h2 class="text-3xl font-bold text-center mb-6">{{ $quiz->title }}</h2>
        <p class="text-lg text-gray-700 text-center mb-8">{{ $quiz->description }}</p>
        <button wire:click="startQuiz" class="bg-blue-500 text-white font-semibold py-4 px-6 rounded-lg shadow-md hover:bg-blue-600 transition-all">
            Start Test
        </button>
    @elseif($currentQuestion)
        <div class="flex flex-col justify-center items-center p-12">
            <h4 class="text-2xl font-semibold text-center mb-8">{{ $currentQuestion->question_text }}</h4>
            <div class="grid grid-cols-2 gap-8 w-full">
                @foreach($currentQuestion->answers as $answer)
                    <button wire:click="selectAnswer({{ $answer->id }})"
                            class="py-4 px-6 rounded-lg shadow-md transition-all border-2 w-full
                            @if($selectedAnswer)
                                @if($answer->is_correct) border-green-500 @elseif($selectedAnswer == $answer->id) border-red-500 @else border-gray-300 @endif
                            @else
                                border-blue-500 hover:border-blue-600
                            @endif
                            text-black font-semibold">
                        {{ $answer->answer_text }}
                    </button>
                @endforeach
            </div>
        </div>
        @if($selectedAnswer)
            <button wire:click="nextQuestion" class="mt-8 bg-blue-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-blue-600 transition-all">
                Next Question
            </button>
        @endif
    @else
        <div class="text-center">
            <p class="text-2xl font-semibold text-gray-700">Thank you for participating!</p>
        </div>
    @endif
</div>
