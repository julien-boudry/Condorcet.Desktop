{{-- Main Livewire view for the ElectionManager component --}}
<div class="flex flex-col lg:flex-row gap-6 p-4 lg:p-6">

    {{-- ──────────────────────────────────────────────
         Left sidebar — Election setup panels
         ────────────────────────────────────────────── --}}
    <aside class="w-full lg:w-96 shrink-0 space-y-4 lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:py-2 lg:-my-2">
        {{-- Reset button — only shown when election has data --}}
        @if(count($candidates) > 0 || count($votes) > 0)
            <div class="rounded-lg border border-red-200 dark:border-red-900/50 bg-red-50 dark:bg-red-950/30 px-4 py-3 flex items-center justify-between">
                <span class="text-sm text-red-700 dark:text-red-400">{{ __('ui.election_in_progress') }}</span>
                <button
                    wire:click="resetElection"
                    wire:confirm="{{ __('ui.confirm_reset') }}"
                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium transition-colors"
                >
                    {{ __('ui.reset') }}
                </button>
            </div>
        @endif

        @include('livewire.partials.import-export')
        @include('livewire.partials.candidate-panel')
        @include('livewire.partials.vote-panel')
        @include('livewire.partials.config-panel')
        @include('livewire.partials.method-selector')
    </aside>

    {{-- ──────────────────────────────────────────────
         Main area — Results display
         ────────────────────────────────────────────── --}}
    <section id="results-section" class="flex-1 min-w-0">
        {{-- Warnings banner --}}
        @if(count($warnings) > 0)
            <div class="mb-4 rounded-lg border border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 p-4">
                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-1">{{ __('ui.warnings') }}</h3>
                <ul class="text-sm text-amber-800 dark:text-amber-300 list-disc list-inside space-y-1">
                    @foreach($warnings as $warning)
                        <li>{{ $warning }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('livewire.partials.results-display')
    </section>

    {{-- ──────────────────────────────────────────────
         localStorage sync via Alpine / @script
         ────────────────────────────────────────────── --}}
    @script
    <script>
        // On component mount, hydrate from localStorage
        const saved = localStorage.getItem('electionState');
        if (saved) {
            try {
                const state = JSON.parse(saved);
                await $wire.loadFromLocalStorage(state);
            } catch (e) {
                console.warn('Failed to parse saved election state', e);
            }
        }

        // Persist state to localStorage whenever it changes
        $wire.on('election-state-updated', ({ state }) => {
            localStorage.setItem('electionState', JSON.stringify(state));
        });
    </script>
    @endscript

    {{-- Floating "See Results" button — mobile only, visible when results exist --}}
    @if(!($computedResults['empty'] ?? true))
        <div
            x-data="{
                visible: false,
                check() {
                    const target = document.getElementById('results-section');
                    if (!target) { this.visible = false; return; }
                    const rect = target.getBoundingClientRect();
                    const distToBottom = document.documentElement.scrollHeight - window.scrollY - window.innerHeight;
                    this.visible = rect.top > window.innerHeight && distToBottom > 150;
                }
            }"
            x-init="check(); window.addEventListener('scroll', () => check(), { passive: true }); window.addEventListener('resize', () => check(), { passive: true })"
            class="lg:hidden"
        >
            <a
                href="#results-section"
                x-show="visible"
                x-transition
                class="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-brand px-4 py-3 text-white text-sm font-semibold shadow-lg hover:bg-brand/90 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
                {{ __('ui.see_results') }}
            </a>
        </div>
    @endif
</div>
