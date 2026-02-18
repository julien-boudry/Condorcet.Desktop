{{-- Results display area --}}
@if($computedResults['empty'] ?? true)
    {{-- Empty state --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-8 text-center">
        <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">No results to display</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
            Add at least <strong>2 candidates</strong> and <strong>1 vote</strong> to compute results.
            @if(count($methods) === 0 && count($candidates) >= 2 && count($votes) > 0)
                <br/>Then select one or more <strong>voting methods</strong>.
            @endif
        </p>
    </div>
@else
    <div class="space-y-4" x-data="{ activeTab: '{{ !empty($computedResults['results']) ? 'overview' : 'pairwise' }}' }">
        {{-- Condorcet winner / loser banner --}}
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Condorcet winner --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Condorcet Winner</span>
                    <p class="text-xl font-semibold mt-0.5">
                        @if($computedResults['condorcetWinner'])
                            <span class="text-green-600 dark:text-green-400">{{ $computedResults['condorcetWinner'] }}</span>
                        @else
                            <span class="relative inline-block" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
                                <span class="text-gray-400 dark:text-gray-500 italic cursor-help">None</span>
                                <span x-show="show" x-cloak x-transition.opacity class="absolute left-0 top-full mt-1 z-10 w-64 rounded-lg bg-gray-900 dark:bg-gray-700 text-white text-xs px-3 py-2 shadow-lg">
                                    No candidate beats every other candidate in pairwise comparison. This means there is a cycle or tie in voter preferences.
                                </span>
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Condorcet loser --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Condorcet Loser</span>
                    <p class="text-xl font-semibold mt-0.5">
                        @if($computedResults['condorcetLoser'])
                            <span class="text-red-600 dark:text-red-400">{{ $computedResults['condorcetLoser'] }}</span>
                        @else
                            <span class="relative inline-block" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
                                <span class="text-gray-400 dark:text-gray-500 italic cursor-help">None</span>
                                <span x-show="show" x-cloak x-transition.opacity class="absolute left-0 top-full mt-1 z-10 w-64 rounded-lg bg-gray-900 dark:bg-gray-700 text-white text-xs px-3 py-2 shadow-lg">
                                    No candidate loses to every other candidate in pairwise comparison. This means there is a cycle or tie in voter preferences.
                                </span>
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Summary counts --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Election</span>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-0.5">
                        {{ count($candidates) }} candidates · {{ count($votes) }} vote entries
                    </p>
                </div>
            </div>
        </div>

        {{-- Tab navigation (pure Alpine.js, no server round-trip) --}}
        @if(!empty($computedResults['results']) || !empty($computedResults['pairwise']))
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex gap-4 overflow-x-auto" role="tablist">
                    {{-- Overview tab (only if methods selected) --}}
                    @if(!empty($computedResults['results']))
                        <button
                            @click="activeTab = 'overview'"
                            :class="activeTab === 'overview' ? 'border-b-2 border-brand text-brand bg-brand/10 rounded-t' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                            class="px-3 py-3 text-sm font-medium whitespace-nowrap transition-colors"
                            role="tab"
                        >
                            Overview
                        </button>
                    @endif

                    {{-- Pairwise tab — always next to Overview --}}
                    @if(!empty($computedResults['pairwise']))
                        <button
                            @click="activeTab = 'pairwise'"
                            :class="activeTab === 'pairwise' ? 'border-b-2 border-brand text-brand bg-brand/10 rounded-t' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                            class="px-3 py-3 text-sm font-medium whitespace-nowrap transition-colors"
                            role="tab"
                        >
                            Pairwise Matrix
                        </button>
                    @endif

                    {{-- Separator between global tabs and per-method tabs --}}
                    @if(!empty($computedResults['results']))
                        <div class="self-center shrink-0 h-5 w-px bg-gray-300 dark:bg-gray-600"></div>
                    @endif

                    {{-- Per-method tabs --}}
                    @foreach($computedResults['results'] as $method => $result)
                        <button
                            @click="activeTab = '{{ md5($method) }}'"
                            :class="activeTab === '{{ md5($method) }}' ? 'border-b-2 border-brand text-brand' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                            class="px-1 py-3 text-sm font-medium whitespace-nowrap transition-colors"
                            role="tab"
                        >
                            {{ $method }}
                        </button>
                    @endforeach
                </nav>
            </div>
        @endif

        {{-- Tab panels --}}
        <div>
            {{-- Overview panel: side-by-side comparison of all methods --}}
            @if(!empty($computedResults['results']))
                <div x-show="activeTab === 'overview'" x-cloak>
                    @include('livewire.partials.results-overview', ['results' => $computedResults['results']])
                </div>

                {{-- Individual method panels --}}
                @foreach($computedResults['results'] as $method => $result)
                    <div x-show="activeTab === '{{ md5($method) }}'" x-cloak>
                        @include('livewire.partials.results-method-detail', ['method' => $method, 'result' => $result])
                    </div>
                @endforeach
            @endif

            {{-- Pairwise matrix panel --}}
            @if(!empty($computedResults['pairwise']))
                <div x-show="activeTab === 'pairwise'" x-cloak>
                    @include('livewire.partials.pairwise-matrix', ['pairwise' => $computedResults['pairwise']])
                </div>
            @endif
        </div>
    </div>
@endif
