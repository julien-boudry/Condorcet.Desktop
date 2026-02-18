{{-- Candidate management panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Candidates</h2>

    {{-- Add single candidate --}}
    <form wire:submit="addCandidate" class="flex gap-2 mb-3">
        <input
            type="text"
            wire:model="newCandidate"
            placeholder="Candidate name…"
            class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
        />
        <button
            type="submit"
            class="bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors"
        >
            Add
        </button>
    </form>

    @error('newCandidate')
        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
    @enderror

    {{-- Bulk add (semicolon-separated) --}}
    <details class="mb-3">
        <summary class="text-sm text-gray-500 dark:text-gray-400 cursor-pointer hover:text-gray-700 dark:hover:text-gray-300">
            Add multiple at once…
        </summary>
        <form wire:submit="addCandidatesBulk" class="flex gap-2 mt-2">
            <input
                type="text"
                wire:model="candidatesBulk"
                placeholder="Alice ; Bob ; Charlie"
                class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
            />
            <button
                type="submit"
                class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium rounded-lg px-4 py-2 text-sm transition-colors"
            >
                Add all
            </button>
        </form>
    </details>

    {{-- Current candidates list --}}
    @if(count($candidates) > 0)
        <ul class="space-y-1">
            @foreach($candidates as $index => $candidate)
                <li wire:key="candidate-{{ $index }}" class="flex items-center justify-between rounded-md px-3 py-1.5 text-sm even:bg-gray-50 dark:even:bg-gray-800/50">
                    <span class="text-gray-900 dark:text-gray-100">{{ $candidate }}</span>
                    <button
                        wire:click="removeCandidate({{ $index }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-xs transition-colors"
                        title="Remove {{ $candidate }}"
                    >
                        ✕
                    </button>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500 italic">No candidates yet.</p>
    @endif
</div>
