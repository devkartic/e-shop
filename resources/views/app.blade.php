<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/images/logos/favicon.png') }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('admin/css/theme.css') }}"/>

    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.2-web/css/all.css') }}"/>

    @vite('resources/css/app.css')

    <title inertia>{{ config('app.name', 'e-Shop') }}</title>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="bg-white">

@inertia

<script src="{{ asset('fontawesome-free-6.5.2-web/js/all.js') }}"></script>

<script src="{{ asset('admin/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/libs/iconify-icon/dist/iconify-icon.min.js') }}"></script>
<script src="{{ asset('admin/libs/@preline/dropdown/index.js') }}"></script>
<script src="{{ asset('admin/libs/@preline/overlay/index.js') }}"></script>
<script src="{{ asset('admin/js/sidebarmenu.js') }}"></script>


{{--<script src="{{ asset('admin/libs/apexcharts/dist/apexcharts.min.js') }}"></script>--}}
{{--<script src="{{ asset('admin/js/dashboard.js') }}"></script>--}}
</body>

</html>
