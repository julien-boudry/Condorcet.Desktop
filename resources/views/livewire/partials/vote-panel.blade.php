{{-- Vote management panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.votes') }}</h2>

    {{-- Add a vote --}}
    <form wire:submit="addVote" class="space-y-2 mb-3">
        {{-- Ranking input --}}
        <input
            type="text"
            wire:model="newVoteRanking"
            placeholder="{{ __('ui.vote_placeholder') }}"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-mono text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
        />

        <div class="flex gap-2">
            {{-- Weight (only when weight is allowed) --}}
            @if($weightAllowed)
                <div class="flex-1">
                    <label class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ __('ui.weight') }}</label>
                    <input
                        type="number"
                        wire:model="newVoteWeight"
                        min="1"
                        placeholder="{{ __('ui.weight_auto') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    />
                </div>
            @endif

            {{-- Quantity --}}
            <div class="flex-1">
                <label class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ __('ui.quantity') }}</label>
                <input
                    type="number"
                    wire:model="newVoteQuantity"
                    min="1"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                />
            </div>

            {{-- Submit --}}
            <div class="flex items-end">
                <button
                    type="submit"
                    class="bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors"
                >
                    {{ __('ui.add_vote') }}
                </button>
            </div>
        </div>
    </form>

    @error('newVoteRanking')
        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
    @enderror

    {{-- Current votes list --}}
    @if(count($votes) > 0)
        <div class="space-y-1 max-h-64 overflow-y-auto">
            @foreach($votes as $index => $vote)
                <div wire:key="vote-{{ $index }}" class="flex items-center justify-between rounded-md px-3 py-1.5 text-sm even:bg-gray-50 dark:even:bg-gray-800/50">
                    <div class="min-w-0 flex-1">
                        <span class="font-mono text-gray-900 dark:text-gray-100">{{ $vote['ranking'] }}</span>
                        @if($weightAllowed && ($vote['weight'] ?? 1) > 1)
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">^{{ $vote['weight'] }}</span>
                        @endif
                        @if(($vote['quantity'] ?? 1) > 1)
                            <span class="text-xs text-brand ml-1">×{{ $vote['quantity'] }}</span>
                        @endif
                    </div>
                    <button
                        wire:click="removeVote({{ $index }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-xs ml-2 shrink-0 transition-colors"
                        title="{{ __('ui.remove_vote') }}"
                    >
                        ✕
                    </button>
                </div>
            @endforeach
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            {{ trans_choice('ui.vote_entries', $computedResults['countVotes'] ?? count($votes)) }}
            @if($weightAllowed && ($computedResults['sumVoteWeights'] ?? 0) > 0)
                <span class="italic">({{ __('ui.total_weight') }} {{ $computedResults['sumVoteWeights'] }})</span>
            @endif
        </p>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500 italic">{{ __('ui.no_votes') }}</p>
    @endif
</div>
