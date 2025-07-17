<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Chỉnh sửa thông tin cá nhân">
    <meta name="author" content="">
    <meta name="keywords" content="chỉnh sửa thông tin, tài khoản">
    <meta name="robots" content="all">
    <title>Chỉnh sửa thông tin cá nhân - PhoneStore</title>

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
                            <i class="fa fa-edit" style="color: #28a745;"></i> Chỉnh sửa thông tin cá nhân
                        </h2>
                        <p style="color: #666;">Cập nhật thông tin tài khoản của bạn</p>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 20px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('customer.update') }}" method="POST">
                        @csrf
                        
                        <!-- Basic Info -->
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px;">
                                <i class="fa fa-user"></i> Thông tin cơ bản
                            </h4>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" style="font-weight: bold; color: #333;">
                                            Họ và tên <span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name', $user->name) }}" required
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" style="font-weight: bold; color: #333;">
                                            Email <span style="color: red;">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ old('email', $user->email) }}" required
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" style="font-weight: bold; color: #333;">
                                            Số điện thoại
                                        </label>
                                        <input type="text" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone', $user->phone) }}" 
                                               placeholder="VD: 0909123456"
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address" style="font-weight: bold; color: #333;">
                                            Địa chỉ
                                        </label>
                                        <textarea class="form-control" id="address" name="address" rows="3" 
                                                  placeholder="Nhập địa chỉ của bạn"
                                                  style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px;">
                                <i class="fa fa-key"></i> Đổi mật khẩu (tùy chọn)
                            </h4>
                            <p style="color: #666; margin-bottom: 15px;">
                                <i class="fa fa-info-circle"></i> Để trống nếu không muốn đổi mật khẩu
                            </p>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="current_password" style="font-weight: bold; color: #333;">
                                            Mật khẩu hiện tại
                                        </label>
                                        <input type="password" class="form-control" id="current_password" name="current_password"
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password" style="font-weight: bold; color: #333;">
                                            Mật khẩu mới
                                        </label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password_confirmation" style="font-weight: bold; color: #333;">
                                            Xác nhận mật khẩu mới
                                        </label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                            <button type="submit" class="btn btn-success" style="margin-right: 10px; padding: 10px 25px;">
                                <i class="fa fa-save"></i> Cập nhật thông tin
                            </button>
                            <a href="{{ route('customer.index') }}" class="btn btn-default" style="padding: 10px 25px;">
                                <i class="fa fa-times"></i> Hủy bỏ
                            </a>
                        </div>
                    </form>

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