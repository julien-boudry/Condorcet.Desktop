{{-- Import / Export panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Import / Export</h2>

    {{-- Import .cvotes --}}
    <details class="mb-3">
        <summary class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer hover:text-brand">
            Import from .cvotes format
        </summary>
        <div class="mt-2">
            <textarea
                wire:model="importText"
                rows="6"
                placeholder="#/Candidates: Alice ; Bob ; Charlie&#10;#/Implicit Ranking: true&#10;&#10;Alice > Bob > Charlie * 3&#10;Bob > Alice > Charlie"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-mono text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
            ></textarea>
            @error('importText')
                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
            <button
                wire:click="importCvotes"
                class="mt-2 bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors"
            >
                Import
            </button>
        </div>
    </details>

    {{-- Export .cvotes --}}
    <details>
        <summary class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer hover:text-brand">
            Export to .cvotes format
        </summary>
        <div class="mt-2">
            <button
                wire:click="exportCvotes"
                class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium rounded-lg px-4 py-2 text-sm transition-colors"
            >
                Generate export
            </button>
            @error('exportOutput')
                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
            @if($exportOutput !== '')
                <textarea
                    readonly
                    rows="8"
                    class="mt-2 w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-sm font-mono text-gray-900 dark:text-gray-100 focus:outline-none"
                >{{ $exportOutput }}</textarea>
            @endif
        </div>
    </details>

    {{-- Reset button --}}
    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
        <button
            wire:click="resetElection"
            wire:confirm="Are you sure you want to reset the entire election?"
            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium transition-colors"
        >
            Reset election
        </button>
    </div>
</div>
