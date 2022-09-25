<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="{{asset('shop/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('shop/css/styles.css')}}" rel="stylesheet" />
    <script src="{{asset('shop/js/all.js')}}" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
@yield('content')

<script src="{{asset('shop/js/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>
<script src="{{asset('shop/js/scripts.js')}}"></script>
<script src="{{asset('shop/js/datatables.js')}}" crossorigin="anonymous"></script>
<script src="{{asset('shop/js/datatables-simple-demo.js')}}"></script>
</body>
</html>
