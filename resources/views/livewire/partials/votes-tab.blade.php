{{-- Votes list tab — displayed in the results area for a complete view --}}
@php
    /** @var array<int, bool> $voteValidity — per-source-vote constraint validity from computeResults() */
    $voteValidity = $computedResults['voteValidity'] ?? [];
    $hasConstraints = !empty($voteValidity);
    $invalidCount = $hasConstraints ? count(array_filter($voteValidity, static fn (bool $v): bool => !$v)) : 0;
@endphp
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
    {{-- Header --}}
    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
            {{ __('ui.votes_list_heading') }}
        </h3>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            {{ trans_choice('ui.vote_entries', count($votes)) }}
            @if($weightAllowed && ($computedResults['sumVoteWeights'] ?? 0) > 0)
                <span class="italic ml-1">({{ __('ui.total_weight') }} {{ $computedResults['sumVoteWeights'] }})</span>
            @endif
            @if($hasConstraints && $invalidCount > 0)
                <span class="ml-2 text-amber-600 dark:text-amber-400 font-medium">
                    — {{ trans_choice('ui.n_invalid_under_constraints', $invalidCount) }}
                </span>
            @endif
        </span>
    </div>

    {{-- Vote table --}}
    @if(count($votes) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/50 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">{{ __('ui.full_ranking') }}</th>
                        @if($weightAllowed)
                            <th class="px-4 py-2 text-center">{{ __('ui.weight') }}</th>
                        @endif
                        <th class="px-4 py-2 text-center">{{ __('ui.quantity') }}</th>
                        @if($hasConstraints)
                            <th class="px-4 py-2 text-center">{{ __('ui.status') }}</th>
                        @endif
                        <th class="px-4 py-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($votes as $index => $vote)
                        @php
                            /** Whether this vote passes currently active constraints */
                            $isValid = $voteValidity[$index] ?? true;
                        @endphp
                        <tr wire:key="vote-row-{{ $index }}" class="{{ $isValid ? 'hover:bg-gray-50 dark:hover:bg-gray-800/30' : 'bg-amber-50/50 dark:bg-amber-950/20 opacity-60' }} transition-colors">
                            <td class="px-4 py-2 text-gray-400 dark:text-gray-500 tabular-nums">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-mono {{ $isValid ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500 line-through' }}">{{ $vote['ranking'] }}</td>
                            @if($weightAllowed)
                                <td class="px-4 py-2 text-center tabular-nums">
                                    @if(($vote['weight'] ?? 1) > 1)
                                        <span class="text-gray-700 dark:text-gray-300">{{ $vote['weight'] }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">1</span>
                                    @endif
                                </td>
                            @endif
                            <td class="px-4 py-2 text-center tabular-nums">
                                @if(($vote['quantity'] ?? 1) > 1)
                                    <span class="text-brand font-medium">×{{ $vote['quantity'] }}</span>
                                @else
                                    <span class="text-gray-300 dark:text-gray-600">1</span>
                                @endif
                            </td>
                            @if($hasConstraints)
                                <td class="px-4 py-2 text-center">
                                    @if($isValid)
                                        <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/40 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-400">
                                            {{ __('ui.vote_valid') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/40 px-2 py-0.5 text-xs font-medium text-amber-700 dark:text-amber-400" title="{{ __('ui.vote_rejected_by_constraint') }}">
                                            {{ __('ui.vote_invalid') }}
                                        </span>
                                    @endif
                                </td>
                            @endif
                            <td class="px-4 py-2 text-right">
                                <button
                                    wire:click="removeVote({{ $index }})"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                    title="{{ __('ui.remove_vote') }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-4 py-8 text-center">
            <p class="text-sm text-gray-400 dark:text-gray-500 italic">{{ __('ui.no_votes') }}</p>
        </div>
    @endif
</div>