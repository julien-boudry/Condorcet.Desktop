{{-- Candidate management panel --}}
<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.candidates') }}</h2>

    {{-- Add one or many candidates (semicolon-separated) --}}
    <form wire:submit="addCandidate" class="flex gap-2 mb-3">
        <input
            type="text"
            wire:model="newCandidate"
            placeholder="{{ __('ui.candidate_placeholder') }}"
            class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
        />
        <button
            type="submit"
            class="bg-brand hover:bg-brand-dark text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors"
        >
            {{ __('ui.add') }}
        </button>
    </form>
    <p class="text-xs text-gray-400 dark:text-gray-500 -mt-2 mb-3">{{ __('ui.candidate_hint') }}</p>

    @error('newCandidate')
        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
    @enderror

    {{-- Current candidates list --}}
    @if(count($candidates) > 0)
        <ul class="space-y-1">
            @foreach($candidates as $index => $candidate)
                <li wire:key="candidate-{{ $index }}" class="flex items-center justify-between rounded-md px-3 py-1.5 text-sm even:bg-gray-50 dark:even:bg-gray-800/50">
                    <span class="text-gray-900 dark:text-gray-100">{{ $candidate }}</span>
                    <button
                        wire:click="removeCandidate({{ $index }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-xs transition-colors"
                        title="{{ __('ui.remove_candidate', ['candidate' => $candidate]) }}"
                    >
                        ✕
                    </button>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500 italic">{{ __('ui.no_candidates') }}</p>
    @endif
</div>
