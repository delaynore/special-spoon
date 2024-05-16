<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

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

<body class="flex flex-col w-full min-h-screen font-sans antialiased">
    <div class="flex flex-col flex-grow w-full bg-gray-100 dark:bg-gray-900">
        @if (isset($navigation))
        @include('components.navigation.navbar')
        @endif

        <!-- Page Heading
        @if (isset($header))
        <header class="bg-white shadow dark:bg-gray-800">
            <div class="flex flex-col items-center px-4 py-6 mx-auto md:flex-row md:justify-between max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif -->

        <!-- Page Content -->
        <main class="flex flex-grow w-full">
            @if (isset($slot))
            {{ $slot }}
            @endif
        </main>
        <footer>
            @include('components.footer.footer')
        </footer>

        @session('status')
        <x-toast type="success" color='blue'>{{ $value }}</x-toast>
        @endsession

        @session('success')
        <x-toast type="success" color='green'>{{ $value }}</x-toast>
        @endsession
        @session('error')
        <x-toast type="error" color='red'>{{ $value }}</x-toast>
        @endsession
        @session('attribute.create.success')
        <x-toast type="success" color='green'>{{ $value }}</x-toast>
        @endsession
        @session('attribute.update.success')
        <x-toast type="success" color='green'>{{ $value }}</x-toast>
        @endsession
        @session('attribute.delete.error')
        <x-toast type="error" color='red'>{{ $value }}</x-toast>
        @endsession
        @session('attribute.delete.success')
        <x-toast type="success" color='red'>{{ $value }}</x-toast>
        @endsession
    </div>
</body>

</html>
