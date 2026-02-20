{{-- Vote management panel (sidebar) --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.votes') }}</h2>

    {{-- Add a single vote --}}
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
                    wire:loading.attr="disabled"
                    class="bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="addVote">{{ __('ui.add_vote') }}</span>
                    <span wire:loading wire:target="addVote" class="inline-flex items-center gap-1">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                </button>
            </div>
        </div>
    </form>

    @error('newVoteRanking')
        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
    @enderror

    {{-- Bulk add votes button (opens modal) --}}
    <div x-data="{ showBulkModal: false }" x-on:bulk-votes-added.window="showBulkModal = false">
        <button
            @click="showBulkModal = true"
            class="w-full rounded-lg border border-dashed border-gray-300 dark:border-gray-600 px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:border-brand hover:text-brand dark:hover:border-brand dark:hover:text-brand transition-colors"
        >
            <span class="flex items-center justify-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
                {{ __('ui.bulk_add_votes') }}
            </span>
        </button>

        {{-- Bulk add modal (Alpine.js overlay) --}}
        <template x-teleport="body">
            <div
                x-show="showBulkModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
                @keydown.escape.window="showBulkModal = false"
            >
                <div
                    @click.outside="showBulkModal = false"
                    class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 w-full max-w-xl"
                >
                    {{-- Modal header --}}
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('ui.parse_votes_title') }}</h3>
                        <button @click="showBulkModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    {{-- Modal body --}}
                    <div class="px-5 py-4 space-y-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {!! __('ui.parse_votes_desc') !!}
                        </p>

                        <textarea
                            wire:model="parseVotesText"
                            rows="10"
                            placeholder="{{ __('ui.parse_votes_placeholder') }}"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-mono text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none resize-y"
                        ></textarea>

                        @error('parseVotesText')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modal footer --}}
                    <div class="flex justify-end gap-2 px-5 py-4 border-t border-gray-200 dark:border-gray-700">
                        <button
                            @click="showBulkModal = false"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        >
                            {{ __('ui.cancel') }}
                        </button>
                        <button
                            wire:click="bulkAddVotes"
                            wire:loading.attr="disabled"
                            class="bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="bulkAddVotes">{{ __('ui.parse_votes_submit') }}</span>
                            <span wire:loading wire:target="bulkAddVotes" class="inline-flex items-center gap-1">
                                <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ __('ui.computing') }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Vote summary --}}
    @if(count($votes) > 0)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
            {{ trans_choice('ui.vote_entries', $computedResults['countVotes'] ?? count($votes)) }}
            @if($weightAllowed && ($computedResults['sumVoteWeights'] ?? 0) > 0)
                <span class="italic">({{ __('ui.total_weight') }} {{ $computedResults['sumVoteWeights'] }})</span>
            @endif
        </p>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500 italic mt-3">{{ __('ui.no_votes') }}</p>
    @endif
</div>
