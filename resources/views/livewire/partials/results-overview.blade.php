{{-- Overview: side-by-side comparison of all selected methods --}}
@php
    // Collect winners to detect disagreements (used by the notice above the table)
    $winners = array_column($results, 'winner');
    $uniqueWinners = array_unique(array_filter($winners));
    $hasDisagreement = count($uniqueWinners) > 1;
@endphp

{{-- Disagreement notice — shown above the table, below the tabs --}}
@if($hasDisagreement)
    <div class="mb-4 rounded-lg border border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 px-4 py-3">
        <p class="text-sm text-amber-800 dark:text-amber-300">
            <strong>Methods disagree on the winner.</strong>
            Different voting methods can produce different results — this is the core insight of social choice theory.
        </p>
    </div>
@endif

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Method</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Winner</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Loser</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Full Ranking</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($results as $method => $result)
                    @php
                        $isDisagreeing = $hasDisagreement && $result['winner'] !== null && $result['winner'] !== reset($uniqueWinners);
                    @endphp
                    <tr class="even:bg-gray-50 dark:even:bg-gray-800/50 {{ $isDisagreeing ? 'bg-amber-50 dark:bg-amber-900/10' : '' }}">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                            {{ $method }}
                            @if($result['isProportional'] ?? false)
                                <span class="text-xs text-brand ml-1" title="Proportional method ({{ $result['seats'] ?? 0 }} seats)">
                                    ● {{ $result['seats'] ?? 0 }} seats
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($result['winner'])
                                <span class="font-semibold text-green-600 dark:text-green-400 {{ $isDisagreeing ? 'underline decoration-amber-400' : '' }}">
                                    {{ $result['winner'] }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($result['loser'])
                                <span class="text-red-600 dark:text-red-400">{{ $result['loser'] }}</span>
                            @else
                                <span class="text-gray-400 italic">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <span class="font-mono text-xs text-gray-700 dark:text-gray-300">
                                @foreach($result['ranking'] as $rank => $candidates)
                                    @if($rank > 1) &gt; @endif
                                    {{ implode(' = ', $candidates) }}
                                @endforeach
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

