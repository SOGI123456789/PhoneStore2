<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>Flipmart premium HTML5 & CSS3 Template</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets\css\bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets\css\main.css">
	    <link rel="stylesheet" href="assets\css\blue.css">
	    <link rel="stylesheet" href="assets\css\owl.carousel.css">
		<link rel="stylesheet" href="assets\css\owl.transitions.css">
		<link rel="stylesheet" href="assets\css\animate.min.css">
		<link rel="stylesheet" href="assets\css\rateit.css">
		<link rel="stylesheet" href="assets\css\bootstrap-select.min.css">

		

		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets\css\font-awesome.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>


	</head>
    <body class="cnt-home">
		<!-- ============================================== HEADER ============================================== -->
@include('partials.headerKH')
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="home">Home</a></li>
				<li class='active'>Login</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="sign-in-page">
			<div class="row">
				<!-- Hiển thị thông báo lỗi và thành công -->
				@if ($errors->any())
				    <div class="col-md-12">
				        <div class="alert alert-danger">
				            <ul style="margin: 0;">
				                @foreach ($errors->all() as $error)
				                    <li>{{ $error }}</li>
				                @endforeach
				            </ul>
				        </div>
				    </div>
				@endif

				@if (session('success'))
				    <div class="col-md-12">
				        <div class="alert alert-success">
				            {{ session('success') }}
				        </div>
				    </div>
				@endif

				<!-- Sign-in -->			
<div class="col-md-6 col-sm-6 sign-in">
    <h4 class="">Sign in</h4>
    <p class="">Hello, Welcome to your account.</p>
    <div class="social-sign-in outer-top-xs">
        <a href="#" class="facebook-sign-in"><i class="fa fa-facebook"></i> Sign In with Facebook</a>
        <a href="#" class="twitter-sign-in"><i class="fa fa-twitter"></i> Sign In with Twitter</a>
    </div>
    <form class="register-form outer-top-xs" role="form" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="info-title" for="login_email">Email Address <span>*</span></label>
            <input type="email" class="form-control unicase-form-control text-input" id="login_email" name="email" value="{{ old('email') }}" required>
        </div>
      	<div class="form-group">
            <label class="info-title" for="login_password">Password <span>*</span></label>
            <input type="password" class="form-control unicase-form-control text-input" id="login_password" name="password" required>
        </div>
        <div class="radio outer-xs">
          	<label>
            	<input type="checkbox" name="remember" id="remember" value="1">Remember me!
          	</label>
          	<a href="#" class="forgot-password pull-right">Forgot your Password?</a>
        </div>
      	<button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
    </form>					
</div>
<!-- Sign-in -->

<!-- create a new account -->
<div class="col-md-6 col-sm-6 create-new-account">
    <h4 class="checkout-subtitle">Create a new account</h4>
    <p class="text title-tag-line">Create your new account.</p>
    <form class="register-form outer-top-xs" role="form" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="info-title" for="register_email">Email Address <span>*</span></label>
            <input type="email" class="form-control unicase-form-control text-input" id="register_email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label class="info-title" for="register_name">Name <span>*</span></label>
            <input type="text" class="form-control unicase-form-control text-input" id="register_name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label class="info-title" for="register_phone">Phone Number <span>*</span></label>
            <input type="tel" class="form-control unicase-form-control text-input" id="register_phone" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div class="form-group">
            <label class="info-title" for="register_password">Password <span>*</span></label>
            <input type="password" class="form-control unicase-form-control text-input" id="register_password" name="password" required>
        </div>
        <div class="form-group">
            <label class="info-title" for="password_confirmation">Confirm Password <span>*</span></label>
            <input type="password" class="form-control unicase-form-control text-input" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Sign Up</button>
    </form>
</div>
<!-- create a new account -->			</div><!-- /.row -->
		</div><!-- /.sigin-in-->
</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ============================================================= FOOTER ============================================================= -->
@include('partials.footerKH')
<!-- ============================================================= FOOTER : END============================================================= -->


	<!-- For demo purposes – can be removed on production -->
	
	
	<!-- For demo purposes – can be removed on production : End -->

	<!-- JavaScripts placed at the end of the document so the pages load faster -->
	<script src="assets\js\jquery-1.11.1.min.js"></script>
	
	<script src="assets\js\bootstrap.min.js"></script>
	
	<script src="assets\js\bootstrap-hover-dropdown.min.js"></script>
	<script src="assets\js\owl.carousel.min.js"></script>
	
	<script src="assets\js\echo.min.js"></script>
	<script src="assets\js\jquery.easing-1.3.min.js"></script>
	<script src="assets\js\bootstrap-slider.min.js"></script>
    <script src="assets\js\jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets\js\lightbox.min.js"></script>
    <script src="assets\js\bootstrap-select.min.js"></script>
    <script src="assets\js\wow.min.js"></script>
	<script src="assets\js\scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>
