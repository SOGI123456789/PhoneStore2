<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="MediaCenter, Template, eCommerce">
	<meta name="robots" content="all">
	<title>Flipmart premium HTML5 & CSS3 Template</title>

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

	<!-- Customizable CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/blue.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.transitions.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/rateit.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/do.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">

	<!-- Icons/Glyphs -->
	<link rel="stylesheet" href="assets\css\font-awesome.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
		rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>

<body class="cnt-home">

	<!-- ============================================== HEADER ============================================== -->
	@include('partials.headerKH')	
	<!-- ============================================== HEADER : END ============================================== -->
	<!-- ============================================================= CONTENT ============================================================= -->
	<div class="body-content outer-top-xs">
		<div class="container">
			<div class="row">
				<!-- Nếu có sidebar, để ở đây -->
				<!-- <div class="col-xs-12 col-sm-12 col-md-3 sidebar"> ... </div> -->

				<!-- PHẦN CHI TIẾT SẢN PHẨM -->
				<div class="col-xs-12 col-sm-12 col-md-9">
					<div class="row">
						<!-- Hình ảnh sản phẩm -->
						<div class="col-md-5">
							<div style="border:1px solid #eee; border-radius:8px; background:#fff; padding:20px; text-align:center;">
								@if($product->image_link)
									<img src="{{ asset('storage/' . $product->image_link) }}" alt="{{ $product->name }}" style="max-width:100%;max-height:350px;object-fit:contain;">
								@else
									<div style="width:100%;height:350px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">
										<i class="fa fa-image" style="font-size:60px;color:#ccc;"></i>
									</div>
								@endif
							</div>
						</div>
						<!-- Thông tin sản phẩm -->
						<div class="col-md-7">
							<h2 style="font-weight:700;">{{ $product->name }}</h2>
							<div style="margin: 15px 0;">
								<span style="color:#e74c3c; font-size: 28px; font-weight: bold;">
									{{ number_format($product->price, 0, ',', '.') }}đ
								</span>
							</div>
							<div style="margin-bottom: 20px;">
								@if($product->description)
									<p>{{ $product->description }}</p>
								@endif
							</div>
							<form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
    @csrf
    <div style="margin-bottom: 15px;">
        <label for="quantity" style="font-weight:500;">Số lượng:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" style="width:70px; padding:5px; border-radius:4px; border:1px solid #ccc;">
    </div>
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="btn btn-primary" style="background: linear-gradient(45deg, #e74c3c, #c0392b); border:none; border-radius:5px; padding:10px 30px; font-size:18px;">
        Mua ngay
    </button>
</form>
						</div>
					</div>

					<!-- Bảng thông số kỹ thuật -->
					<div class="row" style="margin-top:40px;">
						<div class="col-md-12">
							<h3 style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: #fff; padding: 10px 15px; border-radius: 5px 5px 0 0;">
								Thông số kỹ thuật
							</h3>
							<table class="table table-bordered" style="background: #fff;">
								<tbody>
								@if($product->attributes && $product->attributes->count())
									@foreach($product->attributes as $attr)
										<tr>
											<td style="width:220px;font-weight:bold;">{{ ucfirst($attr->attribute_key) }}</td>
											<td>{{ $attr->attribute_value }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="2" class="text-center text-muted">Chưa có thông số kỹ thuật</td>
									</tr>
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- KẾT THÚC PHẦN CHI TIẾT SẢN PHẨM -->
			</div>
		</div>
	</div>
	@include('partials.footerKH')
	<!-- ============================================================= FOOTER : END============================================================= -->


	<!-- For demo purposes – can be removed on production -->


	<!-- For demo purposes – can be removed on production : End -->

	<!-- JavaScripts placed at the end of the document so the pages load faster -->
	<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-hover-dropdown.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/echo.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.easing-1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.rateit.min.js') }}"></script>
<script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/do.js') }}"></script>

</body>

</html>
