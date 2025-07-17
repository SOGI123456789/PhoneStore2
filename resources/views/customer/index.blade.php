<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Thông tin cá nhân">
    <meta name="author" content="">
    <meta name="keywords" content="thông tin cá nhân, tài khoản">
    <meta name="robots" content="all">
    <title>Thông tin cá nhân - PhoneStore</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.transitions.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rateit.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select.min.css')}}">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.css')}}">

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body class="cnt-home">

<!-- ============================================== HEADER ============================================== -->
@include('partials.headerKH')
<!-- ============================================== HEADER : END ============================================== -->

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    
                    <!-- Header -->
                    <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                        <h2 style="color: #333; margin-bottom: 10px;">
                            <i class="fa fa-user-circle" style="color: #007bff;"></i> Thông tin cá nhân
                        </h2>
                        <p style="color: #666;">Quản lý và cập nhật thông tin tài khoản của bạn</p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success" style="margin-bottom: 20px;">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Profile Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 20px;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 5px;">
                                    <i class="fa fa-user"></i> Họ và tên:
                                </label>
                                <div style="padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px;">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 20px;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 5px;">
                                    <i class="fa fa-envelope"></i> Email:
                                </label>
                                <div style="padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px;">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 20px;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 5px;">
                                    <i class="fa fa-phone"></i> Số điện thoại:
                                </label>
                                <div style="padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px;">
                                    {{ $user->phone ?: 'Chưa cập nhật' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 20px;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 5px;">
                                    <i class="fa fa-calendar"></i> Ngày tham gia:
                                </label>
                                <div style="padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px;">
                                    {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin-bottom: 20px;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 5px;">
                                    <i class="fa fa-map-marker"></i> Địa chỉ:
                                </label>
                                <div style="padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; min-height: 50px;">
                                    {{ $user->address ?: 'Chưa cập nhật' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                        <a href="{{ route('customer.edit') }}" class="btn btn-primary" style="margin-right: 10px; padding: 10px 25px;">
                            <i class="fa fa-edit"></i> Chỉnh sửa thông tin
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-default" style="padding: 10px 25px;">
                            <i class="fa fa-home"></i> Về trang chủ
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================= FOOTER ============================================================= -->
@include('partials.footerKH')
<!-- ============================================================= FOOTER : END============================================================= --> 

<!-- JavaScripts placed at the end of the document so the pages load faster --> 
<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script> 
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script> 
<script src="{{asset('assets/js/bootstrap-hover-dropdown.min.js')}}"></script> 
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script> 
<script src="{{asset('assets/js/echo.min.js')}}"></script> 
<script src="{{asset('assets/js/jquery.easing-1.3.min.js')}}"></script> 
<script src="{{asset('assets/js/bootstrap-slider.min.js')}}"></script> 
<script src="{{asset('assets/js/jquery.rateit.min.js')}}"></script> 
<script src="{{asset('assets/js/jquery.prettyPhoto.min.js')}}"></script> 
<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>