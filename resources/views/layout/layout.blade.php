<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('inc.link_scripts')
    @yield('links')
    <style>
        * {
            /* outline: 1px dashed red; */
        }
    </style>
</head>

<body class="w-full min-h-screen bg-neutral-200 relative">
    @include('layout.nav')
    <main class="w-full relative min-h-[90vh]">
        @if (request()->is('admin/student/*'))
            <a href="{{ route('student.index') }}"
                class="btn bg-green-700 hover:bg-green-400 text-white absolute top-5 left-5 z-10">
                <i class="bi bi-arrow-return-left"></i>
                Back
            </a>
        @endif
        @yield('notif')
        @yield('content')
    </main>

</body>

</html>
