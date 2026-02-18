{{-- Election configuration panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Configuration</h2>

    <div class="space-y-3">
        {{-- Implicit ranking toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                wire:model.live="implicitRanking"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Implicit ranking</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    When enabled, unranked candidates are implicitly tied at the last position.
                    When disabled, they receive no points.
                </p>
            </div>
        </label>

        {{-- Vote weight toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                wire:model.live="weightAllowed"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Allow vote weight</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    When enabled, each vote can carry a different weight that amplifies its influence.
                </p>
            </div>
        </label>

        {{-- No-tie constraint toggle --}}
        <label class="flex items-start gap-3 cursor-pointer">
            <input
                type="checkbox"
                wire:model.live="noTieConstraint"
                class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
            />
            <div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">No-tie constraint</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Reject votes that contain ties. Recommended for some proportional methods (STV).
                </p>
            </div>
        </label>

        {{-- Number of seats --}}
        <div>
            <label for="seats" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Number of seats
            </label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                Required for proportional methods (STV, D'Hondt, Sainte-Laguë, etc.).
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
</div>
