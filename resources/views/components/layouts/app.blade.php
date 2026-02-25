<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Condorcet Desktop</title>
        <link rel="icon" href="{{ asset('images/condorcet-logo.avif') . '?v=' . filemtime(public_path('images/condorcet-logo.avif')) }}" type="image/avif" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Apply dark mode class before render to prevent flash --}}
        <script>
            if (localStorage.getItem('colorScheme') === 'dark' ||
                (!localStorage.getItem('colorScheme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body class="h-full bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans">
        {{-- Top navigation bar --}}
        <nav class="sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-xs">
            <div class="mx-auto max-w-screen-2xl flex items-center justify-between px-4 py-3">
                {{-- Logo & app name --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/condorcet-logo.avif') . '?v=' . filemtime(public_path('images/condorcet-logo.avif')) }}" alt="Condorcet Logo" class="h-8 w-8" />
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ config('app.name') }}</span>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Language selector (dropdown) --}}
                    <div
                        x-data="{ open: false }"
                        @click.outside="open = false"
                        class="relative"
                    >
                        @php
                            $locales = config('locales.supported');
                            $currentLocale = app()->getLocale();
                        @endphp
                        <button
                            @click="open = !open"
                            class="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-sm text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="uppercase font-medium">{{ $currentLocale }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div
                            x-show="open"
                            x-cloak
                            x-transition.opacity
                            class="absolute right-0 mt-1 w-40 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg py-1 z-50"
                        >
                            @foreach($locales as $code => $label)
                                <button
                                    @click="
                                        if ('{{ $currentLocale }}' !== '{{ $code }}') {
                                            document.cookie = 'locale={{ $code }}; path=/; max-age=31536000; SameSite=Lax';
                                            location.reload();
                                        }
                                        open = false;
                                    "
                                    class="w-full text-left px-3 py-1.5 text-sm transition-colors {{ $currentLocale === $code ? 'font-semibold text-brand bg-brand/5' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Dark mode toggle --}}
                    <button
                        x-data="{ dark: document.documentElement.classList.contains('dark') }"
                        x-on:click="dark = !dark; document.documentElement.classList.toggle('dark'); localStorage.setItem('colorScheme', dark ? 'dark' : 'light')"
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors"
                        :title="dark ? '{{ __('ui.switch_to_light') }}' : '{{ __('ui.switch_to_dark') }}'"
                    >
                        {{-- Sun icon (visible in dark mode) --}}
                        <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                        </svg>
                        {{-- Moon icon (visible in light mode) --}}
                        <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        {{-- Main content --}}
        <main class="mx-auto max-w-screen-2xl">
            {{ $slot }}
        </main>
    </body>
</html>
