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
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Flipmart premium HTML5 & CSS3 Template</title>

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
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Shopping Cart</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row ">
			<div class="shopping-cart">
				<div class="shopping-cart-table ">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th class="cart-romove item">Remove</th>
					<th class="cart-description item">Image</th>
					<th class="cart-product-name item">Product Name</th>
					<th class="cart-edit item">Edit</th>
					<th class="cart-qty item">Quantity</th>
					<th class="cart-sub-total item">Subtotal</th>
					<th class="cart-total last-item">Grandtotal</th>
				</tr>
			</thead><!-- /thead -->
			<tbody>
				@if(count($cart) > 0)
					@foreach($cart as $id => $item)
					<tr>
						<td class="romove-item">
							<a href="#" onclick="removeFromCart({{ $id }})" title="cancel" class="icon">
								<i class="fa fa-trash-o"></i>
							</a>
						</td>
						<td class="cart-image">
							<a class="entry-thumbnail" href="{{ route('product.detail', $id) }}">
								@if($item['image'])
									<img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 70px; height: 70px; object-fit: cover;">
								@else
									<img src="{{ asset('assets/images/products/default.jpg') }}" alt="{{ $item['name'] }}" style="width: 70px; height: 70px; object-fit: cover;">
								@endif
							</a>
						</td>
						<td class="cart-product-name-info">
							<h4 class='cart-product-description'>
								<a href="{{ route('product.detail', $id) }}">{{ $item['name'] }}</a>
							</h4>
							<div class="cart-product-info">
								<span class="product-price">Giá: {{ number_format($item['price'], 0, ',', '.') }}đ</span>
							</div>
						</td>
						<td class="cart-product-edit">
							<a href="{{ route('product.detail', $id) }}" class="product-edit">Chi tiết</a>
						</td>
						<td class="cart-product-quantity">
							<div class="quant-input">
								<div class="arrows">
									<div class="arrow plus gradient" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})">
										<span class="ir"><i class="icon fa fa-sort-asc"></i></span>
									</div>
									<div class="arrow minus gradient" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})">
										<span class="ir"><i class="icon fa fa-sort-desc"></i></span>
									</div>
								</div>
								<input type="text" value="{{ $item['quantity'] }}" id="qty-{{ $id }}" readonly>
							</div>
						</td>
						<td class="cart-product-sub-total">
							<span class="cart-sub-total-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
						</td>
						<td class="cart-product-grand-total">
							<span class="cart-grand-total-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
						</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="7" style="text-align: center; padding: 50px;">
							<h4>Giỏ hàng của bạn đang trống</h4>
							<a href="{{ route('index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
						</td>
					</tr>
				@endif
			</tbody><!-- /tbody -->
		</table><!-- /table -->
	</div>
</div><!-- /.shopping-cart-table -->

			<!-- Shopping Cart Summary -->
			<div class="row">
				<div class="col-md-5">
					@if(count($cart) > 0)
					<div class="customer-info">
						<h3>Thông tin khách hàng</h3>
						<form id="customerForm">
							@csrf
							<div class="form-group">
								<label for="customer_name">Họ và tên *</label>
								<input type="text" class="form-control" id="customer_name" name="customer_name" 
									   value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
							</div>
							<div class="form-group">
								<label for="customer_email">Email *</label>
								<input type="email" class="form-control" id="customer_email" name="customer_email" 
									   value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
							</div>
							<div class="form-group">
								<label for="customer_phone">Số điện thoại</label>
								<input type="text" class="form-control" id="customer_phone" name="customer_phone" 
									   value="{{ auth()->check() && auth()->user()->phone ? auth()->user()->phone : '' }}">
							</div>
							<div class="form-group">
								<label for="customer_address">Địa chỉ</label>
								<textarea class="form-control" id="customer_address" name="customer_address" rows="3">{{ auth()->check() && auth()->user()->address ? auth()->user()->address : '' }}</textarea>
							</div>
							<div class="form-group">
								<label for="notes">Ghi chú</label>
								<textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Ghi chú đơn hàng (không bắt buộc)"></textarea>
							</div>
							<div class="form-group">
								<label for="payment_method">Phương thức thanh toán *</label>
								<select class="form-control" id="payment_method" name="payment_method" required>
									<option value="cod">Thanh toán khi nhận hàng (COD)</option>
									<option value="bank_transfer">Chuyển khoản ngân hàng</option>
								</select>
							</div>
						</form>
					</div>
					@endif
				</div>
				<div class="col-md-3">
					<div class="cart-shopping-total">
						<table class="table">
							<thead>
								<tr>
									<th>
										<div class="cart-sub-total">
											Tổng tiền<span class="inner-left-md">{{ number_format($total, 0, ',', '.') }}đ</span>
										</div>
										<div class="cart-grand-total">
											Thành tiền<span class="inner-left-md">{{ number_format($total, 0, ',', '.') }}đ</span>
										</div>
									</th>
								</tr>
							</thead><!-- /thead -->
							<tbody>
								<tr>
									<td>
										<div class="cart-checkout-btn pull-right">
											@if(count($cart) > 0)
												<button type="button" onclick="proceedToCheckout()" class="btn btn-primary checkout-btn">Gửi đơn hàng</button>
												<button type="button" onclick="payWithMomo()" class="btn btn-success" style="margin-left:10px;">Thanh toán qua Momo</button>
												<button type="button" onclick="payWithBankQr()" class="btn btn-info" style="margin-left:10px;">Thanh toán qua Ngân hàng</button>
											@endif
										</div>
									</td>
								</tr>
							</tbody><!-- /tbody -->
						</table><!-- /table -->
					</div><!-- /.cart-shopping-total -->
				</div>
			</div>
			
		</div><!-- /.shopping-cart -->
		</div> <!-- /.row -->
		<!-- ============================================== BRANDS CAROUSEL ============================================== -->
<div id="brands-carousel" class="logo-slider wow fadeInUp">

		<div class="logo-slider-inner">	
			<div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
				<div class="item m-t-15">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand1.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item m-t-10">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand2.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand3.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand4.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand5.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand6.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand2.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand4.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand1.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->

				<div class="item">
					<a href="#" class="image">
						<img data-echo="assets/images/brands/brand5.png" src="assets\images\blank.gif" alt="">
					</a>	
				</div><!--/.item-->
			</div><!-- /.owl-carousel #logo-slider -->
		</div><!-- /.logo-slider-inner -->
	
</div><!-- /.logo-slider -->
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	</div><!-- /.container -->
</div><!-- /.body-content -->

<!-- ============================================================= FOOTER ============================================================= -->
@include('partials.footerKH')

		<!-- ============================================================= FOOTER : END ============================================================= -->
<!-- ============================================================= FOOTER : END============================================================= -->


	<!-- For demo purposes – can be removed on production -->
	
	
	<!-- For demo purposes – can be removed on production : End -->

	<!-- JavaScripts placed at the end of the document so the pages load faster -->
	<script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-hover-dropdown.min.js')}}"></script>
	<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('assets/js/echo.min.js')}}"></script>
	<script src="{{asset('assets/js/jquery.easing-1.3.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-slider.min.js')}}"></script>
	<script src="{{asset('assets/js/jquery.rateit.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/lightbox.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('assets/js/wow.min.js')}}"></script>
	<script src="{{asset('assets/js/scripts.js')}}"></script>

	<!-- Modal hiển thị mã QR Momo -->
	<div class="modal fade" id="momoQrModal" tabindex="-1" role="dialog" aria-labelledby="momoQrModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="momoQrModalLabel">Quét mã QR để thanh toán qua Momo</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="text-align:center;">
			<img id="momoQrImg" src="" alt="Momo QR" style="max-width:300px; max-height:300px;" />
			<p style="margin-top:10px;">Vui lòng quét mã QR bằng ứng dụng Momo để thanh toán.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
		  </div>
		</div>
	  </div>
	</div>

	<!-- Modal hiển thị mã QR Ngân hàng -->
	<div class="modal fade" id="bankQrModal" tabindex="-1" role="dialog" aria-labelledby="bankQrModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="bankQrModalLabel">Quét mã QR để chuyển khoản ngân hàng</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="text-align:center;">
			<img id="bankQrImg" src="" alt="Bank QR" style="max-width:300px; max-height:300px;" />
			<p style="margin-top:10px;">Vui lòng quét mã QR bằng ứng dụng ngân hàng để chuyển khoản.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
		  </div>
		</div>
	  </div>
	</div>

	<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function payWithMomo() {
		$.ajax({
			url: '{{ route("momo.qr") }}',
			method: 'POST',
			data: {
				amount: {{ $total }},
				order_code: 'ORDER_TEST_{{ time() }}',
				_token: $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				console.log('Momo response:', response);
				if(response.qr_url) {
					var qrSrc = response.qr_url;
					if(!qrSrc.startsWith('data:image')) {
						qrSrc = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' + encodeURIComponent(response.qr_url);
					}
					$('#momoQrImg').attr('src', qrSrc);
					$('#momoQrModal').modal('show');
				} else {
					alert('Không lấy được mã QR Momo!');
				}
			},
			error: function(xhr) {
				console.log('Momo error:', xhr.responseText);
				alert('Có lỗi xảy ra khi tạo mã QR Momo!');
			}
		});
	}

	function payWithBankQr() {
		$.ajax({
			url: '{{ route("bank.qr") }}',
			method: 'POST',
			data: {
				amount: {{ $total }},
				order_code: 'ORDER_TEST_{{ time() }}',
				_token: $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				console.log('Bank QR response:', response);
				if(response.qr_url) {
					$('#bankQrImg').attr('src', response.qr_url);
					$('#bankQrModal').modal('show');
				} else {
					alert('Không lấy được mã QR Ngân hàng!');
				}
			},
			error: function(xhr) {
				console.log('Bank QR error:', xhr.responseText);
				alert('Có lỗi xảy ra khi tạo mã QR Ngân hàng!');
			}
		});
	}

	function updateQuantity(productId, quantity) {
		if(quantity < 1) {
			removeFromCart(productId);
			return;
		}
		$.ajax({
			url: '{{ route("cart.update") }}',
			method: 'POST',
			data: {
				product_id: productId,
				quantity: quantity
			},
			success: function(response) {
				if(response.success) {
					location.reload();
				}
			},
			error: function(xhr) {
				alert('Có lỗi xảy ra khi cập nhật giỏ hàng!');
			}
		});
	}

	function removeFromCart(productId) {
		if(confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
			$.ajax({
				url: '{{ route("cart.remove") }}',
				method: 'POST',
				data: {
					product_id: productId
				},
				success: function(response) {
					if(response.success) {
						location.reload();
					}
				},
				error: function(xhr) {
					alert('Có lỗi xảy ra khi xóa sản phẩm!');
				}
			});
		}
	}

	function proceedToCheckout() {
		var customerName = $('#customer_name').val();
		var customerEmail = $('#customer_email').val();
		if(!customerName || !customerEmail) {
			alert('Vui lòng nhập đầy đủ họ tên và email!');
			return;
		}
		var customerData = {
			customer_name: customerName,
			customer_email: customerEmail,
			customer_phone: $('#customer_phone').val(),
			customer_address: $('#customer_address').val(),
			notes: $('#notes').val(),
			payment_method: $('#payment_method').val(),
			_token: $('meta[name="csrf-token"]').attr('content')
		};
		if(confirm('Bạn có chắc muốn gửi đơn hàng này?')) {
			$.ajax({
				url: '{{ route("orders.create") }}',
				method: 'POST',
				data: customerData,
				success: function(response) {
					if(response.success) {
						alert('Đơn hàng đã được tạo thành công!');
						window.location.href = '{{ route("index") }}';
					}
				},
				error: function(xhr) {
					var errorMessage = 'Có lỗi xảy ra khi tạo đơn hàng!';
					if(xhr.responseJSON && xhr.responseJSON.error) {
						errorMessage = xhr.responseJSON.error;
					}
					alert(errorMessage);
				}
			});
		}
	}
	$(document).ready(function() {
		$('#bankQrModal').on('hidden.bs.modal', function () {
			proceedToCheckout();
		});
		$('#momoQrModal').on('hidden.bs.modal', function () {
			proceedToCheckout();
		});
	});
	</script>

	

	

</body>
</html>
