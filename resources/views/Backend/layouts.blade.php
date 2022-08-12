<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/Backend/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/Backend/plugins/summernote/summernote-bs4.min.css">
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
    <link rel="stylesheet" href="/Backend/css/adminlte.min.css">
    <link rel="stylesheet" href="/Backend/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.1.4/css/rowGroup.bootstrap.min.css" rel="stylesheet">



    @yield("css")
    <style type="text/css">
        .table td {vertical-align: middle !important;text-align: center !important;}
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #2196f3;
            padding: 3px 7px;
            border-radius: 3px;
        }
        .bootstrap-tagsinput {
            width: 100%;
        }
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.75) url(/Backend/img/loader.gif) no-repeat center center;
            z-index: 10000;
        }


    </style>

    @yield("css")
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include("Backend.inc.header")
    @include("Backend.inc.sidebar")
    @yield("content")
    @include("Backend.inc.footer")

</div>
<div id="loader"></div>

<script src="/Backend/plugins/jquery/jquery.min.js"></script>
<script src="/Backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/Backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="/Backend/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/Backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap4.min.css" />

<script src="/Backend/plugins/dropzone/min/dropzone.min.js"></script>
<script src="/Backend/js/jquery.repeater.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    @if(Session::has('info'))
    iziToast.info({
        title: 'Hello, world!',
        message: 'This awesome plugin is made iziToast toastr',
        position: 'topRight'
    });
    @endif

    @if(Session::has('error'))
    iziToast.error({
        title: 'Hata!',
        message: '{{session('error')}}',
        position: 'topRight'
    });
    @endif



    @if(Session::has('warning'))
    iziToast.warning({
        title: 'Hello, world!',
        message: 'This awesome plugin is made by iziToast',
        position: 'topRight'
    });
    @endif

    @if(Session::has('success'))
    iziToast.success({
        title: 'Başarılı!',
        message: '{{session('success')}}',
        position: 'topRight'
    });
    @endif
</script>
<script src="/Backend/js/adminlte.min.js"></script>
@yield("js")

</body>
</html>
