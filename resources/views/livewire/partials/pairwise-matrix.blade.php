{{-- Pairwise comparison matrix --}}
@php
    $candidateNames = array_keys($pairwise);
@endphp

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.pairwise_heading') }}</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
        {!! __('ui.pairwise_desc') !!}
    </p>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        {{ __('ui.vs') }}
                    </th>
                    @foreach($candidateNames as $opponent)
                        <th class="px-3 py-2 text-center font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 whitespace-nowrap">
                            {{ $opponent }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($candidateNames as $rowCandidate)
                    <tr class="even:bg-gray-50 dark:even:bg-gray-800/50">
                        <td class="px-3 py-2 font-semibold text-gray-900 dark:text-gray-100 border-r border-gray-200 dark:border-gray-700 whitespace-nowrap">
                            {{ $rowCandidate }}
                        </td>
                        @foreach($candidateNames as $colCandidate)
                            <td class="px-3 py-2 text-center font-mono text-xs border-r border-gray-100 dark:border-gray-800 last:border-r-0">
                                @if($rowCandidate === $colCandidate)
                                    <span class="text-gray-300 dark:text-gray-600">—</span>
                                @else
                                    @php
                                        $wins = $pairwise[$rowCandidate]['win'][$colCandidate] ?? 0;
                                        $losses = $pairwise[$rowCandidate]['opposition'][$colCandidate] ?? $pairwise[$rowCandidate]['lose'][$colCandidate] ?? 0;
                                    @endphp
                                    <span class="{{ $wins > $losses ? 'text-green-600 dark:text-green-400 font-semibold' : ($wins < $losses ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400') }}">
                                        {{ $wins }}
                                    </span>
                                    <span class="text-gray-400 dark:text-gray-500">/</span>
                                    <span class="{{ $losses > $wins ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $losses }}
                                    </span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
