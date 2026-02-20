{{-- Election configuration panel --}}
{{--
    Alpine.js manages checkbox state locally for instant visual feedback.
    A shared window-level debounce timer (window.__settingsDebounce) batches
    changes from BOTH the config panel and the method selector into a single
    $wire.applySettings() call.
    wire:ignore prevents Livewire DOM morphing from conflicting with Alpine.
--}}
<div
    class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4"
    x-data="{
        implicitRanking: @js($implicitRanking),
        weightAllowed: @js($weightAllowed),
        noTieConstraint: @js($noTieConstraint),
        sync() {
            if (!window.__pendingSettings) {
                window.__pendingSettings = {};
            }
            window.__pendingSettings.implicitRanking = this.implicitRanking;
            window.__pendingSettings.weightAllowed   = this.weightAllowed;
            window.__pendingSettings.noTieConstraint = this.noTieConstraint;
            clearTimeout(window.__settingsDebounce);
            window.__settingsDebounce = setTimeout(() => {
                const s = window.__pendingSettings;
                window.__pendingSettings = null;
                window.__settingsDebounce = null;
                $wire.applySettings(
                    s.methods          ?? $wire.methods,
                    s.implicitRanking  ?? $wire.implicitRanking,
                    s.weightAllowed    ?? $wire.weightAllowed,
                    s.noTieConstraint  ?? $wire.noTieConstraint
                );
            }, 1000);
        }
    }"
    x-init="$wire.on('election-state-updated', ({ state }) => {
        if (!window.__settingsDebounce) {
            implicitRanking = state.implicitRanking ?? true;
            weightAllowed = state.weightAllowed ?? false;
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
