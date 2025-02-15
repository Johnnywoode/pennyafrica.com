<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> {{ config('app.name') }} | @yield('title') </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('app.favicon')) }}" />
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="{{ config('app.name') }} | @yield('title')" />
    <meta name="author" content="{{ config('app.developer.name') }}" />
    <meta name="description" content="{{ config('app.description') }}" />
    <meta name="keywords" content="{{ config('app.keywords') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--end::Primary Meta Tags-->

    @include('sandbox.panels.styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('sandbox.panels.navbar')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('sandbox.panels.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main bg-body-tertiary">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0 align-items-center">@isset($page_title) {!! $page_title !!} @endisset</h3>
                        </div>
                        <div class="col-sm-6">
                            @include('sandbox.panels.breadcrumbs')
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        @include('sandbox.panels.footer')
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    @include('sandbox.panels.scripts')
</body>

</html>