{{-- Detailed view for a single voting method --}}
<div class="space-y-4">
    {{-- Ranking card --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
            {{ $method }}
            @if($result['isProportional'] ?? false)
                <span class="text-sm font-normal text-brand ml-2">{{ __('ui.proportional_seats', ['seats' => $result['seats'] ?? 0]) }}</span>
            @endif
        </h3>

        {{-- Active method options --}}
        @if(!empty($result['methodOptions']))
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($result['methodOptions'] as $label => $value)
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 text-xs text-gray-600 dark:text-gray-400">
                        <span class="font-medium">{{ $label }}:</span> {{ $value }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Winner & Loser (only for single-winner methods) --}}
        @if(!($result['isProportional'] ?? false) && !($result['isInformational'] ?? false))
            <div class="flex gap-6 mb-4">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('ui.winner') }}</span>
                    <p class="text-lg font-semibold text-green-600 dark:text-green-400">
                        {{ $result['winner'] ?? '—' }}
                    </p>
                </div>
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('ui.loser') }}</span>
                    <p class="text-lg font-semibold text-red-600 dark:text-red-400">
                        {{ $result['loser'] ?? '—' }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Full ranking table --}}
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-300 w-16">{{ __('ui.rank') }}</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-300">{{ __('ui.candidates_header') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result['ranking'] as $rank => $candidates)
                    <tr class="even:bg-gray-50 dark:even:bg-gray-800/50">
                        <td class="px-3 py-2 text-gray-600 dark:text-gray-400 font-mono">
                            #{{ $rank }}
                        </td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">
                            @if(count($candidates) > 1)
                                <span class="text-brand font-medium" title="{{ __('ui.tied_candidates') }}">
                                    {{ implode(' = ', $candidates) }}
                                </span>
                            @else
                                {{ $candidates[0] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Stats (collapsible) --}}
    @if(!empty($result['stats']))
        <details class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <summary class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                {{ __('ui.computation_statistics') }}
            </summary>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 overflow-x-auto">
                <pre class="text-xs font-mono text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ json_encode($result['stats'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </details>
    @endif
</div>
