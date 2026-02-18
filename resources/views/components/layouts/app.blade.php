<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Condorcet Desktop</title>
        <link rel="icon" href="/images/condorcet-logo.avif" type="image/avif" />

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
                    <img src="/images/condorcet-logo.avif" alt="Condorcet" class="h-8 w-8" />
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Condorcet Desktop</span>
                </div>

                {{-- Dark mode toggle --}}
                <button
                    x-data="{ dark: document.documentElement.classList.contains('dark') }"
                    x-on:click="dark = !dark; document.documentElement.classList.toggle('dark'); localStorage.setItem('colorScheme', dark ? 'dark' : 'light')"
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors"
                    :title="dark ? 'Switch to light mode' : 'Switch to dark mode'"
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
        </nav>

        {{-- Main content --}}
        <main class="mx-auto max-w-screen-2xl">
            {{ $slot }}
        </main>
    </body>
</html>
