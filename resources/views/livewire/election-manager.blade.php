{{-- Main Livewire view for the ElectionManager component --}}
<div class="flex flex-col lg:flex-row gap-6 p-4 lg:p-6">

    {{-- ──────────────────────────────────────────────
         Left sidebar — Election setup panels
         ────────────────────────────────────────────── --}}
    <aside class="w-full lg:w-96 shrink-0 space-y-4">
        @include('livewire.partials.candidate-panel')
        @include('livewire.partials.vote-panel')
        @include('livewire.partials.config-panel')
        @include('livewire.partials.method-selector')
        @include('livewire.partials.import-export')
    </aside>

    {{-- ──────────────────────────────────────────────
         Main area — Results display
         ────────────────────────────────────────────── --}}
    <section class="flex-1 min-w-0">
        {{-- Warnings banner --}}
        @if(count($warnings) > 0)
            <div class="mb-4 rounded-lg border border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 p-4">
                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-1">Warnings</h3>
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
</div>
