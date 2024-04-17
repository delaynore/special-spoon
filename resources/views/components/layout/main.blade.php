<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    <script>
        const themeItemName = 'pradict-preferred-theme';

        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem(themeItemName) === 'dark' || (!(themeItemName in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col justify-between min-h-screen bg-gray-100 dark:bg-gray-900">
        @if (isset($navigation))
            @include('components.navigation.navbar')
        @endif

        <!-- Page Heading
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="flex flex-col md:flex-row md:justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif -->

        <!-- Page Content -->
        <main>
            @if (isset($slot))
            {{ $slot }}
            @endif
        </main>
        <footer>
            @include('components.footer.footer')
        </footer>
    </div>
</body>

</html>
