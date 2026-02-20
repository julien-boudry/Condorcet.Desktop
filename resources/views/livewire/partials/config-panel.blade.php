{{-- Election configuration panel --}}
{{--
    Alpine.js manages checkbox state locally for instant visual feedback.
    $wire.$set() queues updates without sending.  A shared debounce timer
    (window.__settingsDebounce) fires $wire.$commit() after 1 s of
    inactivity.  If another action fires first, Livewire includes the
    pending $set values automatically.
    wire:ignore prevents Livewire DOM morphing from conflicting with Alpine.
--}}
<div
    class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4"
    x-data="(() => {
        let ir = @js($implicitRanking);
        let wa = @js($weightAllowed);
        let ntc = @js($noTieConstraint);
        try {
            const s = JSON.parse(localStorage.getItem('electionState'));
            if (s) {
                if (s.implicitRanking !== undefined) ir = s.implicitRanking;
                if (s.weightAllowed !== undefined)   wa = s.weightAllowed;
                if (s.noTieConstraint !== undefined) ntc = s.noTieConstraint;
            }
        } catch {}
        return {
            implicitRanking: ir,
            weightAllowed: wa,
            noTieConstraint: ntc,
            sync() {
                $wire.$set('implicitRanking', this.implicitRanking, false);
                $wire.$set('weightAllowed', this.weightAllowed, false);
                $wire.$set('noTieConstraint', this.noTieConstraint, false);
                clearTimeout(window.__settingsDebounce);
                window.__settingsDebounce = setTimeout(() => {
                    window.__settingsDebounce = null;
                    $wire.$commit();
                }, 1000);
            }
        };
    })()"
    x-init="$wire.on('election-state-updated', ({ state }) => {
        if (!window.__settingsDebounce) {
            implicitRanking = state.implicitRanking ?? true;
            weightAllowed = state.weightAllowed ?? false;
            noTieConstraint = state.noTieConstraint ?? false;
        }
    })"
>
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.configuration') }}</h2>

    <div wire:ignore class="space-y-3">
        {{-- Implicit ranking toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                x-model="implicitRanking"
                @change="sync()"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.implicit_ranking') }}</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('ui.implicit_ranking_desc') }}
                </p>
            </div>
        </label>

        {{-- Vote weight toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                x-model="weightAllowed"
                @change="sync()"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.allow_vote_weight') }}</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('ui.allow_vote_weight_desc') }}
                </p>
            </div>
        </label>

        {{-- No-tie constraint toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                x-model="noTieConstraint"
                @change="sync()"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.no_tie_constraint') }}</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('ui.no_tie_constraint_desc') }}
                </p>
            </div>
        </label>
    </div>

        {{-- Number of seats (outside wire:ignore — managed by Livewire directly) --}}
        <div class="mt-3">
            <label for="seats" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('ui.number_of_seats') }}
            </label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                {{ __('ui.seats_desc') }}
            </p>
            <input
                type="number"
                id="seats"
                wire:model.live.debounce.500ms="seats"
                min="1"
                class="w-24 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
            />
        </div>
</div>
