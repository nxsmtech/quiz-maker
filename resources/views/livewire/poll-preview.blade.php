<div class="p-4 shadow-lg bg-cover bg-top font-montserrat overflow-y-hidden"
     style="background-image: url('{{ asset('storage/' . $poll->background_image) }}'); background-color: {{ $poll->background_color }}; color: {{ $poll->text_color }};"
     x-data="pollComponent({{ $poll->id }}, {{ $poll->version }})">
    <div class="flex flex-col gap-3">
        @if($poll->logo)
            <img src="{{ asset('storage/' . $poll->logo) }}" alt="poll logo" width="127" height="32" class="object-contain">
        @endif
{{--        <h1 class="text-xl font-bold">{{ $poll->title }}</h1>--}}
    </div>
    <p class="mb-2">{{ $poll->description }}</p>

    <template x-if="!hasVoted">
        <div class="grid grid-cols-1 gap-2">
            <h2 class="text-md font-bold">{{ $poll->question }}</h2>
            @foreach($poll->options as $option)
                <div>
                    <input type="radio" @click="selectOption({{ $option->id }})" name="option" class="mr-2">
                    <label class="font-semibold text-sm">{{ $option->option_text }}</label>
                </div>
            @endforeach
            <button @click="submitVote" class="mt-2 px-1 py-1 rounded w-full text-sm font-semibold"
                    style="background-color: {{ $poll->button_color }}; color: {{ $poll->button_text_color }};">
                {{ $poll->button_text }}
            </button>
        </div>
    </template>

    <template x-if="hasVoted">
        <div>
            <h3 class="mt-2 text-md font-semibold">{{ $poll->results_title }}</h3>
            <p class="mt-2 text-sm">{{ $poll->results_summary }}</p>
            <div class="space-y-2 mt-2">
                @foreach($poll->options as $option)
                    <div class="flex justify-between text-sm">
                        <span>{{ $option->option_text }}</span>
                        <span>{{ $option->votes ? round(($option->votes / $totalVotes) * 100, 2) : 0 }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </template>
</div>

<script>
    function pollComponent(pollId, pollVersion) {
        return {
            hasVoted: localStorage.getItem(`poll_${pollId}_${pollVersion}`) === 'true',
            selectedOption: null,

            selectOption(optionId) {
                this.selectedOption = optionId;
            },

            submitVote() {
                if (!this.selectedOption) {
                    alert('Please select an option');
                    return;
                }

            @this.call('vote')
                .then(() => {
                    this.hasVoted = true;
                    localStorage.setItem(`poll_${pollId}_${pollVersion}`, 'true');
                })
                .catch(() => {
                    alert('Failed to submit your vote.');
                });
            }
        };
    }
</script>
