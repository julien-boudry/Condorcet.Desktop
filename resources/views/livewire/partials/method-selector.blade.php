{{-- Voting methods selection panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Voting Methods</h2>

    <div class="space-y-4">
        @foreach($methodGroups as $groupName => $groupMethods)
            <div>
                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                    {{ $groupName }}
                </h3>
                <div class="space-y-1">
                    @foreach($groupMethods as $alias => $label)
                        <label wire:key="method-{{ $alias }}" class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input
                                type="checkbox"
                                value="{{ $alias }}"
                                @checked(in_array($alias, $methods))
                                wire:click="toggleMethod('{{ $alias }}')"
                                class="rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Per-method options (shown when relevant methods are selected) --}}
    @if(array_intersect($methods, ['BordaCount', 'Kemeny–Young', 'STV', 'CPO STV', 'Sainte-Laguë', 'Largest Remainder']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Method Options</h3>

            {{-- Borda Count starting point --}}
            @if(in_array('BordaCount', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Borda starting point
                    </label>
                    <select
                        wire:model.live="bordaStarting"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    >
                        <option value="1">1 (standard)</option>
                        <option value="0">0</option>
                    </select>
                </div>
            @endif

            {{-- Kemeny-Young max candidates --}}
            @if(in_array('Kemeny–Young', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kemeny–Young max candidates
                    </label>
                    <input
                        type="number"
                        wire:model.live.debounce.500ms="kemenyMaxCandidates"
                        min="3"
                        max="20"
                        placeholder="10 (leave empty for no limit)"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Computation becomes very slow above 10 candidates.
                    </p>
                </div>
            @endif

            {{-- STV quota --}}
            @if(in_array('STV', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">STV quota</label>
                    <select
                        wire:model.live="stvQuota"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    >
                        @foreach($quotaOptions as $q)
                            <option value="{{ $q }}">{{ $q }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- CPO-STV quota --}}
            @if(in_array('CPO STV', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">CPO-STV quota</label>
                    <select
                        wire:model.live="cpoStvQuota"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    >
                        @foreach($quotaOptions as $q)
                            <option value="{{ $q }}">{{ $q }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Sainte-Laguë first divisor --}}
            @if(in_array('Sainte-Laguë', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sainte-Laguë first divisor
                    </label>
                    <input
                        type="number"
                        wire:model.live.debounce.500ms="sainteLagueFirstDivisor"
                        step="0.1"
                        min="1"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        1 = standard · 1.4 = Norwegian variant
                    </p>
                </div>
            @endif

            {{-- Largest Remainder quota --}}
            @if(in_array('Largest Remainder', $methods))
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Largest Remainder quota</label>
                    <select
                        wire:model.live="largestRemainderQuota"
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                    >
                        @foreach($quotaOptions as $q)
                            <option value="{{ $q }}">{{ $q }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    @endif
</div>
