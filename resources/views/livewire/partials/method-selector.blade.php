{{-- Voting methods selection panel --}}
{{--
    Alpine.js manages checkbox state locally for instant visual feedback.
    $wire.$set('methods', value, false) queues the update without sending.
    A shared debounce timer (window.__settingsDebounce) fires $wire.$commit()
    after 1 s of inactivity.  If another action fires first, Livewire
    includes the pending $set values automatically.
    wire:ignore prevents Livewire DOM morphing from conflicting with Alpine.
--}}
<div
    class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4"
    x-data="{
        selected: (() => {
            try {
                const s = JSON.parse(localStorage.getItem('electionState'));
                if (s?.methods) return s.methods;
            } catch {}
            return @js($methods);
        })(),
        toggle(alias) {
            const idx = this.selected.indexOf(alias);
            if (idx > -1) { this.selected.splice(idx, 1); } else { this.selected.push(alias); }
            this.scheduleSync();
        },
        scheduleSync() {
            $wire.$set('methods', [...this.selected], false);
            clearTimeout(window.__settingsDebounce);
            window.__settingsDebounce = setTimeout(() => {
                window.__settingsDebounce = null;
                $wire.$commit();
            }, 1000);
        }
    }"
    x-init="$wire.on('election-state-updated', ({ state }) => {
        if (!window.__settingsDebounce) {
            selected = state.methods ?? [];
        }
    })"
>
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">{{ __('ui.voting_methods') }}</h2>

    <div wire:ignore class="space-y-4">
        @foreach($methodGroups as $groupName => $groupMethods)
            <div>
                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">
                    @php
                        $groupKeys = ['Single Winner' => 'group_single_winner', 'Proportional' => 'group_proportional', 'Informational' => 'group_informational'];
                    @endphp
                    {{ __('ui.' . ($groupKeys[$groupName] ?? $groupName)) }}
                </h3>
                <div class="space-y-1">
                    @foreach($groupMethods as $alias => $label)
                        <label class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input
                                type="checkbox"
                                value="{{ $alias }}"
                                :checked="selected.includes('{{ $alias }}')"
                                @click="toggle('{{ $alias }}')"
                                class="rounded border-gray-300 dark:border-gray-600 text-brand focus:ring-brand"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Per-method options (shown when relevant methods are selected) --}}
    @if(!empty($activeMethodOptions))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('ui.method_options') }}</h3>

            @foreach($activeMethodOptions as $opt)
                <div wire:key="opt-{{ $opt['wire'] }}">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $opt['label'] }}
                    </label>

                    @if($opt['type'] === 'select')
                        {{-- Generic select with explicit choices --}}
                        <select
                            wire:model.live="{{ $opt['wire'] }}"
                            class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                        >
                            @foreach($opt['choices'] as $choice)
                                <option value="{{ $choice['value'] }}">{{ $choice['label'] }}</option>
                            @endforeach
                        </select>

                    @elseif($opt['type'] === 'number')
                        {{-- Number input with debounce --}}
                        <input
                            type="number"
                            wire:model.live.debounce.500ms="{{ $opt['wire'] }}"
                            @if(isset($opt['min'])) min="{{ $opt['min'] }}" @endif
                            @if(isset($opt['max'])) max="{{ $opt['max'] }}" @endif
                            @if(isset($opt['step'])) step="{{ $opt['step'] }}" @endif
                            @if(isset($opt['placeholder'])) placeholder="{{ $opt['placeholder'] }}" @endif
                            class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                        />

                    @elseif($opt['type'] === 'quota')
                        {{-- Quota selector (StvQuotas enum options) --}}
                        <select
                            wire:model.live="{{ $opt['wire'] }}"
                            class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:border-brand focus:ring-1 focus:ring-brand focus:outline-none"
                        >
                            @foreach($quotaOptions as $q)
                                <option value="{{ $q }}">{{ $q }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if(isset($opt['hint']))
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $opt['hint'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
