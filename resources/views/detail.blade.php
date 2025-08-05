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
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
	<link rel="stylesheet" href="{{ asset('assets/css/reviews.css') }}">

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
							
							<!-- Phần chọn variant (màu sắc, RAM, ROM) -->
							@php
								$colors = $product->variants->pluck('color')->unique()->filter();
								$rams = $product->variants->pluck('ram')->unique()->filter();
								$roms = $product->variants->pluck('rom')->unique()->filter();
							@endphp
							
							@if($colors->count() > 0)
							<div style="margin: 15px 0;">
								<h5 style="font-weight:600;">Màu sắc:</h5>
								<div class="color-options" style="display: flex; gap: 10px; flex-wrap: wrap;">
									@foreach($colors as $color)
									<button type="button" class="color-option btn" 
										data-color="{{ $color }}" 
										style="
											padding: 8px 15px; 
											border: 2px solid #ddd; 
											border-radius: 20px; 
											background: #fff; 
											cursor: pointer;
											transition: all 0.3s ease;
										"
										onclick="selectVariant('color', this, '{{ $color }}')">
										{{ $color }}
									</button>
									@endforeach
								</div>
							</div>
							@endif
							
							@if($rams->count() > 0)
							<div style="margin: 15px 0;">
								<h5 style="font-weight:600;">Cấu hình RAM:</h5>
								<div class="ram-options" style="display: flex; gap: 10px; flex-wrap: wrap;">
									@foreach($rams as $ram)
									<button type="button" class="ram-option btn" 
										data-ram="{{ $ram }}" 
										style="
											padding: 8px 15px; 
											border: 2px solid #ddd; 
											border-radius: 20px; 
											background: #fff; 
											cursor: pointer;
											transition: all 0.3s ease;
										"
										onclick="selectVariant('ram', this, '{{ $ram }}')">
										{{ $ram }}
									</button>
									@endforeach
								</div>
							</div>
							@endif
							
							@if($roms->count() > 0)
							<div style="margin: 15px 0;">
								<h5 style="font-weight:600;">Bộ nhớ trong:</h5>
								<div class="rom-options" style="display: flex; gap: 10px; flex-wrap: wrap;">
									@foreach($roms as $rom)
									<button type="button" class="rom-option btn" 
										data-rom="{{ $rom }}" 
										style="
											padding: 8px 15px; 
											border: 2px solid #ddd; 
											border-radius: 20px; 
											background: #fff; 
											cursor: pointer;
											transition: all 0.3s ease;
										"
										onclick="selectVariant('rom', this, '{{ $rom }}')">
										{{ $rom }}
									</button>
									@endforeach
								</div>
							</div>
							@endif
							
							<div style="margin: 15px 0;">
								<span id="product-price" style="color:#e74c3c; font-size: 28px; font-weight: bold;">
									{{ number_format($product->price, 0, ',', '.') }}đ
								</span>
								<span id="discount-price" style="color:#999; font-size: 20px; text-decoration: line-through; margin-left: 10px; display: none;">
								</span>
								<div id="stock-status" style="margin-top: 5px; font-size: 14px;">
									<span class="badge badge-success">Còn hàng</span>
								</div>
							</div>
							
							<div style="margin-bottom: 20px;">
								@if($product->content)
									<p>{{ $product->content }}</p>
								@endif
							</div>
							
							<form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
								@csrf
								<div style="margin-bottom: 15px;">
									<label for="quantity" style="font-weight:500;">Số lượng:</label>
									<input type="number" id="quantity" name="quantity" value="1" min="1" max="1" style="width:70px; padding:5px; border-radius:4px; border:1px solid #ccc;">
									<span id="max-quantity" style="font-size: 12px; color: #666;"></span>
								</div>
								<input type="hidden" name="product_id" value="{{ $product->id }}">
								<input type="hidden" id="selected-variant-id" name="variant_id" value="">
								<input type="hidden" id="selected-color" name="selected_color" value="">
								<input type="hidden" id="selected-ram" name="selected_ram" value="">
								<input type="hidden" id="selected-rom" name="selected_rom" value="">
								<button type="submit" id="add-to-cart-btn" class="btn btn-primary" style="background: linear-gradient(45deg, #e74c3c, #c0392b); border:none; border-radius:5px; padding:10px 30px; font-size:18px;" disabled>
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
									@foreach($product->attributes->whereNotIn('attribute_key', ['color', 'ram', 'rom', 'storage']) as $attr)
										<tr>
											<td style="width:220px;font-weight:bold;">{{ ucfirst(str_replace('_', ' ', $attr->attribute_key)) }}</td>
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
		
		<!-- PRODUCT REVIEWS SECTION -->
		@include('partials.product-reviews')
		<!-- END PRODUCT REVIEWS SECTION -->
		
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
<script src="{{ asset('assets/js/reviews.js') }}"></script>

<script>
// Dữ liệu variants từ database
const productVariants = @json($product->variants);

// Trạng thái hiện tại
let selectedVariants = {
	color: '',
	ram: '',
	rom: ''
};

function selectVariant(type, element, value) {
	// Bỏ chọn tất cả các option cùng loại
	const optionClass = type + '-option';
	document.querySelectorAll('.' + optionClass).forEach(btn => {
		btn.style.background = '#fff';
		btn.style.borderColor = '#ddd';
		btn.style.color = '#333';
	});
	
	// Chọn option hiện tại
	element.style.background = 'linear-gradient(45deg, #e74c3c, #c0392b)';
	element.style.borderColor = '#e74c3c';
	element.style.color = '#fff';
	
	// Cập nhật trạng thái
	selectedVariants[type] = value;
	document.getElementById('selected-' + type).value = value;
	
	updatePrice();
}

function updatePrice() {
	// Tìm variant phù hợp
	const matchingVariant = productVariants.find(variant => {
		return (!selectedVariants.color || variant.color === selectedVariants.color) &&
			   (!selectedVariants.ram || variant.ram === selectedVariants.ram) &&
			   (!selectedVariants.rom || variant.rom === selectedVariants.rom);
	});
	
	if (matchingVariant) {
		// Cập nhật giá
		const price = matchingVariant.price;
		const discountPrice = matchingVariant.discount_price;
		
		document.getElementById('product-price').innerHTML = 
			new Intl.NumberFormat('vi-VN').format(price) + 'đ';
		
		// Hiển thị giá gốc nếu có discount
		const discountElement = document.getElementById('discount-price');
		if (discountPrice && discountPrice < price) {
			discountElement.innerHTML = new Intl.NumberFormat('vi-VN').format(discountPrice) + 'đ';
			discountElement.style.display = 'inline';
		} else {
			discountElement.style.display = 'none';
		}
		
		// Cập nhật trạng thái kho
		const stockElement = document.getElementById('stock-status');
		const quantityInput = document.getElementById('quantity');
		const maxQuantityElement = document.getElementById('max-quantity');
		const addToCartBtn = document.getElementById('add-to-cart-btn');
		
		if (matchingVariant.quantity > 0) {
			stockElement.innerHTML = '<span class="badge badge-success">Còn ' + matchingVariant.quantity + ' sản phẩm</span>';
			quantityInput.max = matchingVariant.quantity;
			quantityInput.disabled = false;
			maxQuantityElement.innerHTML = '(Tối đa: ' + matchingVariant.quantity + ')';
			addToCartBtn.disabled = false;
			addToCartBtn.style.opacity = '1';
		} else {
			stockElement.innerHTML = '<span class="badge badge-danger">Hết hàng</span>';
			quantityInput.disabled = true;
			maxQuantityElement.innerHTML = '';
			addToCartBtn.disabled = true;
			addToCartBtn.style.opacity = '0.5';
		}
		
		// Lưu variant ID
		document.getElementById('selected-variant-id').value = matchingVariant.id;
		
	} else {
		// Không tìm thấy variant phù hợp
		document.getElementById('product-price').innerHTML = 'Không có sẵn';
		document.getElementById('stock-status').innerHTML = '<span class="badge badge-warning">Chọn đầy đủ tùy chọn</span>';
		document.getElementById('add-to-cart-btn').disabled = true;
		document.getElementById('add-to-cart-btn').style.opacity = '0.5';
	}
}

// Tự động chọn variant đầu tiên
document.addEventListener('DOMContentLoaded', function() {
	if (productVariants.length > 0) {
		const firstVariant = productVariants[0];
		
		// Chọn màu đầu tiên
		if (firstVariant.color) {
			const firstColor = document.querySelector('.color-option[data-color="' + firstVariant.color + '"]');
			if (firstColor) {
				selectVariant('color', firstColor, firstVariant.color);
			}
		}
		
		// Chọn RAM đầu tiên
		if (firstVariant.ram) {
			const firstRam = document.querySelector('.ram-option[data-ram="' + firstVariant.ram + '"]');
			if (firstRam) {
				selectVariant('ram', firstRam, firstVariant.ram);
			}
		}
		
		// Chọn ROM đầu tiên
		if (firstVariant.rom) {
			const firstRom = document.querySelector('.rom-option[data-rom="' + firstVariant.rom + '"]');
			if (firstRom) {
				selectVariant('rom', firstRom, firstVariant.rom);
			}
		}
	}
});

// Kiểm tra số lượng khi thay đổi
document.getElementById('quantity').addEventListener('change', function() {
	const max = parseInt(this.max);
	const value = parseInt(this.value);
	
	if (value > max) {
		this.value = max;
		alert('Số lượng tối đa là ' + max);
	}
});
</script>

</body>

</html>
