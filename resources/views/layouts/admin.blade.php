<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @yield('title')
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('adminlte3.0/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte3.0/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('partials.header') {{-- Nạp phần giao diện thanh điều hướng trên cùng header từ file partials/header.blade.php --}}
    @include('partials.siderbar'){{-- Nạp phần menu bên trái từ file partials/sidebar.blade.php --}}
    @yield('content') {{-- Hiển thị nội dung chính của từng trang cụ thể (ví dụ: dashboard, profile, v.v.).
    Các view con sẽ định nghĩa nội dung này bằng @section('content') trong file home.blade.php --}}

    @include('partials.footer'){{-- Nạp phần giao diện thanh điều hướng dươi cùng footer từ file partials/footer.blade.php --}}

</div>
<!-- jQuery -->
<script src="{{asset('adminlte3.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte3.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte3.0/dist/js/adminlte.min.js')}}"></script>
@stack('scripts')
</body>
</html>
