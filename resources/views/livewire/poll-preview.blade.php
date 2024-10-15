<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold">{{ $poll->title }}</h2>
    <p class="text-gray-600 mb-4">{{ $poll->description }}</p>

    @if (!$voted)
        <div class="space-y-2">
            @foreach($poll->options as $option)
                <div>
                    <input type="radio" wire:click="selectOption({{ $option->id }})" name="option" class="mr-2">
                    <label>{{ $option->option_text }}</label>
                </div>
            @endforeach
        </div>

        @if ($selectedOption)
            <button wire:click="vote" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Vote
            </button>
        @endif
    @else
        <h3 class="text-lg font-bold">Results:</h3>
        <div class="space-y-2 mt-4">
            @foreach($poll->options as $option)
                <div class="flex justify-between">
                    <span>{{ $option->option_text }}</span>
                    @if($option->votes)
                        <span>{{ round(($option->votes / $totalVotes) * 100, 2) }}%</span>
                    @else
                        <span>0%</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
