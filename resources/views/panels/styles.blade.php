<!--begin::Fonts-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
<!--end::Fonts-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
    integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Third Party Plugin(Bootstrap Icons)-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
<!--end::Third Party Plugin(Bootstrap Icons)-->
<!--begin::Required Plugin(AdminLTE)-->
<link rel="stylesheet" href="{{ asset('app/css/adminlte/adminlte.min.css') }}" />

<link rel="stylesheet" href="{{ asset('app/css/variables.css') }}" />
<!--end::Required Plugin(AdminLTE)-->

<link rel="stylesheet" href="{{ asset('app/css/sweetalert/sweetalert2.min.css') }}" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-x+IoBzFMD3MmXMfhJxmgJDmxRHiLY/RmNwOucmh95o6Wa8lGGiOg1OujcYoxJlwnavxA0WZ/hKR3prbHwPy6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="{{ asset('app/plugins/select2/css/select2.min.css') }}">
<style>
    a {
        text-decoration: none;
    }
    .input-group .select2-container--default .select2-selection--single {
        height: 100%;
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
    }

    .input-group .select2-selection__rendered {
        line-height: 2.4 !important;
    }

    .input-group .select2-selection__arrow {
        height: 100%;
    }

    .input-group .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
    }
</style>

<!-- apexcharts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
<!-- jsvectormap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />

@yield('page_styles')
