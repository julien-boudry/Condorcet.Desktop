{{-- Results display area --}}
@if(($computedResults['empty'] ?? true) && count($votes) === 0)
    {{-- Empty state — no votes and no results --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-8 text-center">
        <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('ui.no_results') }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
            {!! __('ui.no_results_hint') !!}
            @if(count($methods) === 0 && count($candidates) >= 2 && count($votes) > 0)
                <br/>{!! __('ui.no_results_methods_hint') !!}
            @endif
        </p>
    </div>
@else
    @php
        $hasResults = !($computedResults['empty'] ?? true);
        $hasVotes = count($votes) > 0;
        $hasPairwise = !empty($computedResults['pairwise']);
        $hasMethodResults = !empty($computedResults['results']);

        // Determine default active tab
        $defaultTab = match (true) {
            $hasMethodResults => 'overview',
            $hasPairwise => 'pairwise',
            default => 'votes',
        };
    @endphp

    <div class="space-y-4" x-data="{ activeTab: '{{ $defaultTab }}' }">
        {{-- Condorcet winner / loser banner (only when results exist) --}}
        @if($hasResults)
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Condorcet winner --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.condorcet_winner') }}</span>
                    <p class="text-xl font-semibold mt-0.5">
                        @if($computedResults['condorcetWinner'])
                            <span class="text-green-600 dark:text-green-400">{{ $computedResults['condorcetWinner'] }}</span>
                        @else
                            <span class="relative inline-block" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
                                <span class="text-gray-400 dark:text-gray-500 italic cursor-help">{{ __('ui.none') }}</span>
                                <span x-show="show" x-cloak x-transition.opacity class="absolute left-0 top-full mt-1 z-10 w-64 rounded-lg bg-gray-900 dark:bg-gray-700 text-white text-xs px-3 py-2 shadow-lg">
                                    {{ __('ui.no_condorcet_winner_tooltip') }}
                                </span>
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Condorcet loser --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.condorcet_loser') }}</span>
                    <p class="text-xl font-semibold mt-0.5">
                        @if($computedResults['condorcetLoser'])
                            <span class="text-red-600 dark:text-red-400">{{ $computedResults['condorcetLoser'] }}</span>
                        @else
                            <span class="relative inline-block" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
                                <span class="text-gray-400 dark:text-gray-500 italic cursor-help">{{ __('ui.none') }}</span>
                                <span x-show="show" x-cloak x-transition.opacity class="absolute left-0 top-full mt-1 z-10 w-64 rounded-lg bg-gray-900 dark:bg-gray-700 text-white text-xs px-3 py-2 shadow-lg">
                                    {{ __('ui.no_condorcet_loser_tooltip') }}
                                </span>
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Summary counts --}}
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.election_label') }}</span>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-0.5">
                        {{ trans_choice('ui.n_candidates', count($candidates)) }} · {{ $computedResults['countValidVotes'] }} {{ __('ui.valid_votes') }}
                        @if($weightAllowed)
                            <span class="italic">({{ __('ui.valid_weight') }} {{ $computedResults['sumValidVoteWeights'] }})</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- Tab navigation (pure Alpine.js, no server round-trip) --}}
        <div class="space-y-2">
            {{-- Row 1: Global tabs (Overview + Pairwise + Votes) --}}
            <div class="flex gap-2 border-b border-gray-200 dark:border-gray-700">
                @if($hasMethodResults)
                    <button
                        @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'border-b-2 border-brand text-brand bg-brand/10 rounded-t' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-3 py-3 text-sm font-semibold whitespace-nowrap transition-colors"
                        role="tab"
                    >
                        {{ __('ui.overview') }}
                    </button>
                @endif

                @if($hasPairwise)
                    <button
                        @click="activeTab = 'pairwise'"
                        :class="activeTab === 'pairwise' ? 'border-b-2 border-brand text-brand bg-brand/10 rounded-t' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-3 py-3 text-sm font-semibold whitespace-nowrap transition-colors"
                        role="tab"
                    >
                        {{ __('ui.pairwise_matrix_tab') }}
                    </button>
                @endif

                @if($hasVotes)
                    <button
                        @click="activeTab = 'votes'"
                        :class="activeTab === 'votes' ? 'border-b-2 border-brand text-brand bg-brand/10 rounded-t' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-3 py-3 text-sm font-semibold whitespace-nowrap transition-colors"
                        role="tab"
                    >
                        {{ __('ui.votes_tab') }}
                        <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">({{ count($votes) }})</span>
                    </button>
                @endif
            </div>

            {{-- Row 2: Per-method tabs as wrapping pills --}}
            @if($hasMethodResults)
                <div class="flex flex-wrap gap-1.5" role="tablist">
                    @foreach($computedResults['results'] as $method => $result)
                        <button
                            @click="activeTab = '{{ md5($method) }}'"
                            :class="activeTab === '{{ md5($method) }}' ? 'bg-brand text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="px-2.5 py-1 text-xs font-medium rounded-full transition-colors"
                            role="tab"
                        >
                            {{ $method }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tab panels --}}
        <div>
            {{-- Overview panel: side-by-side comparison of all methods --}}
            @if($hasMethodResults)
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
            @if($hasPairwise)
                <div x-show="activeTab === 'pairwise'" x-cloak>
                    @include('livewire.partials.pairwise-matrix', ['pairwise' => $computedResults['pairwise']])
                </div>
            @endif

            {{-- Votes list panel --}}
            @if($hasVotes)
                <div x-show="activeTab === 'votes'" x-cloak>
                    @include('livewire.partials.votes-tab')
                </div>
            @endif
        </div>

        {{-- Condorcet library version (discreet, bottom-right) --}}
        <p class="text-right text-xs text-gray-400 dark:text-gray-600 mt-2">
            <a href="https://github.com/julien-boudry/Condorcet" target="_blank" rel="noopener" class="hover:text-brand transition-colors">Condorcet PHP v{{ $condorcetVersion }}</a>
        </p>
    </div>
@endif
