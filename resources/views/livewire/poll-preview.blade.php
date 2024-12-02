<div class="p-4 shadow-lg bg-cover bg-top font-montserrat overflow-y-hidden"
     style="background-image: url('{{ asset('storage/' . $poll->background_image) }}'); background-color: {{ $poll->background_color }}; color: {{ $poll->text_color }};">

    {{--    @dd($poll)--}}
    <div class="flex flex flex-col gap-3">
        @if($poll->logo)
            <img src="{{ asset('storage/' . $poll->logo) }}" alt="poll logo" width="127" height="32" class="object-contain">
        @endif
        <h1 class="text-xl font-bold">{{ $poll->title }}</h1>
    </div>
    <p class="mb-2">{{ $poll->description }}</p>

    @if (!$voted)
        <div class="grid grid-cols-1 gap-2">
            <h2 class="text-md font-bold">{{ $poll->question }}</h2>
            @foreach($poll->options as $option)
                <div>
                    <input type="radio" wire:click="selectOption({{ $option->id }})" name="option" class="mr-2">
                    <label class="font-semibold text-sm">{{ $option->option_text }}</label>
                </div>
            @endforeach
        </div>
    @else
        <h3 class="mt-2 text-md font-semibold">{{ $poll->results_title }}</h3>
        <p class="mt-2 text-sm">{{ $poll->results_summary }}</p>
        <div class="space-y-2 mt-2">
            @foreach($poll->options as $option)
                <div class="flex justify-between text-sm">
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
    <div class="flex flex-row grid grid-cols-2 items-center gap-4 mt-4">
{{--        Hidden till option added to filament--}}
{{--        <p class="text-xs font-light">{{ $poll->total_votes_text }}: {{ $totalVotes }}</p>--}}
        @if(!$voted)
            <button wire:click="vote" class="mt-2 px-1 py-1 rounded w-full text-sm font-semibold"
                    style="background-color: {{ $poll->button_color }}; color: {{ $poll->button_text_color }};">
                {{ $poll->button_text }}
            </button>
        @endif
    </div>
</div>
