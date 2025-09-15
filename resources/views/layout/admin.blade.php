<!DOCTYPE html>
<html lang="fr">

<head>
    @yield('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/Logo.png') }}">

    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/remixicon.css') }}">

    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/bootstrap.min.css') }}">

    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/apexcharts.css') }}">

    <!-- Data Table css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/dataTables.min.css') }}" />
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/editor-katex.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/editor.atom-one-dark.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/editor.quill.snow.css') }}" />
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/flatpickr.min.css') }}" />
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/full-calendar.css') }}" />
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/jquery-jvectormap-2.0.5.css') }}" />
    <!-- Popup css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/magnific-popup.css') }}" />
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/slick.css') }}" />
    <!-- prism css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/prism.css') }}" />
    <!-- file upload css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/file-upload.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/lib/audioplayer.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/style.css') }}" />


    <!-- Authers libraries CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/icon/flaticon_digicom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/vendor/splide/splide.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/vendor/animate-wow/animate.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">



    <!-- 
    <link rel="stylesheet" href="{{ URL::asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/datatable/datatables.min.css') }}"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/summernote/summernote.min.css') }}">
    <title>COCEC</title>
</head>

<body>
    @yield('content')

    <!-- <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script> -->


    <!-- jQuery library js -->
    <!-- <script src="{{ URL::asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script> -->
    <script src="{{ URL::asset('assets/admin/js/lib/jquery.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/script.js') }}"></script>

    @yield('js')

    <!-- Bootstrap js -->
    <script src="{{ URL::asset('assets/admin/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ URL::asset('assets/admin/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ URL::asset('assets/admin/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ URL::asset('assets/admin/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ URL::asset('assets/admin/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ URL::asset('assets/admin/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ URL::asset('assets/admin/js/lib/magnific-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ URL::asset('assets/admin/js/lib/slick.min.js') }}"></script>
    <!-- prism js -->
    <script src="{{ URL::asset('assets/admin/js/lib/prism.js') }}"></script>
    <!-- file upload js -->
    <script src="{{ URL::asset('assets/admin/js/lib/file-upload.js') }}"></script>
    <!-- audioplayer -->
    <script src="{{ URL::asset('assets/admin/js/lib/audioplayer.js') }}"></script>

    <!-- main js -->
    <script src="{{ URL::asset('assets/admin/js/app.js') }}"></script>

    <script src="{{ URL::asset('assets/admin/js/homeOneChart.js') }}"></script>

    <script src="{{ URL::asset('assets/admin/summernote/summernote.min.js') }}"></script>


    <!-- libraries JS -->
    <script src="{{ URL::asset('assets/admin/vendor/splide/splide.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/vendor/splide/splide-extension-auto-scroll.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/vendor/animate-wow/wow.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/vendor/fslightbox/fslightbox.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Bannière de Cookies pour l'Administration - Composant Réutilisable -->
    @include('includes.admin.cookie-banner')

</body>

</html>