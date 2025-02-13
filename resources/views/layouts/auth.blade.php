<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }} | @yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="{{ config('app.name') }} | @yield('title')" />
    <meta name="author" content="{{ config('app.developer.name') }}" />
    <meta name="description" content="{{ config('app.description') }}" />
    <meta name="keywords" content="{{ config('app.keywords') }}" />

    @include('panels.styles')

</head>

<body class="login-page bg-body-secondary">

    @yield('content')

    @include('panels.scripts')

</body>

</html>
