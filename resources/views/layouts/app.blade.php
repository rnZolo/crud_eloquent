<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('inc.link_scripts')
    @yield('head')

</head>

<body class="min-h-screen">
    @include('sweetalert::alert')
    <div id="app">
        {{-- @yield('notif') --}}
        @include('layouts.nav')
        <main class="w-full relative min-h-[90vh] pt-[80px]">
            @if (request()->is('admin/student/*'))
                <a href="{{ route('student.index') }}"
                    class="btn bg-green-700 hover:bg-green-400 text-white absolute top-5 left-5 z-10">
                    <i class="bi bi-arrow-return-left"></i>
                    Back
                </a>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>
