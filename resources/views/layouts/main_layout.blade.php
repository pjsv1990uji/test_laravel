<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks - Test</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex items-center justify-center">
        <div class="inline-flex" id="main_menu">
            <ul class="py-9 flex hover:text-indigo-900 " id="menu_nav">
                <li class="w-60 font-semibold text-gray-600" id="button_task">
                    <a class="" href="/tasks">
                        <span class="">Tasks</span>
                    </a>
                </li>
                <li class="" id="button_home">
                    <a class="w-60 font-semibold text-gray-600" href="/create-task">
                        <span class="last firstlevel">Create Task</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <main class="container mx-auto">
        @yield('content')
    </main>

    <livewire:scripts />

    @yield('scripts')
</body>

</html>