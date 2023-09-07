<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('inc.link_scripts')
    @yield('links')

    <title>Document</title>
    <style>
        *{
            /* outline: 1px dashed red; */
        }
    </style>
</head>
<body class="w-full min-h-screen bg-neutral-200">
    @yield('notif')
    @yield('content')
</body>
</html>