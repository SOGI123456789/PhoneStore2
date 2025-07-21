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
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/blue.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.transitions.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/rateit.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/do.css')}}">

<!-- Icons/Glyphs -->
<link rel="stylesheet" href="{{asset('assets/css/font-awesome.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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
<div class="body-content outer-top-xs" id="top-banner-and-menu">
  <div class="container">
    <!-- ============================================== CATEGORIES SECTION ============================================== -->
    <div class="row categories-section" style="margin-bottom: 30px;">
      <div class="col-xs-12">
        
        
        @foreach($parentCategories as $category)
        <div class="category-block" style="margin-bottom: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 20px; background: #f9f9f9;">
          <div class="category-header" style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="margin: 0; text-transform: uppercase; font-weight: bold;">{{ $category->name }}</h3>
          </div>
          
          <div class="row">
            @php
              // Lấy tất cả sản phẩm của danh mục cha (bao gồm sản phẩm trực tiếp và từ danh mục con)
              $allProducts = collect();
              
              // Thêm sản phẩm trực tiếp của danh mục cha
              $allProducts = $allProducts->merge($category->products);
              
              // Thêm sản phẩm từ các danh mục con
              foreach($category->children as $child) {
                $allProducts = $allProducts->merge($child->products);
              }
              
              // Loại bỏ sản phẩm trùng lặp dựa trên ID và lấy 8 sản phẩm đầu tiên
              $displayProducts = $allProducts->unique('id')->take(8);
            @endphp
            
            @if($displayProducts->count() > 0)
              @foreach($displayProducts as $product)
              <div class="col-xs-6 col-sm-6 col-md-3" style="margin-bottom: 20px;">
                <div class="product-item" style="border: 1px solid #eee; border-radius: 5px; padding: 15px; background: white; text-align: center; height: 320px;">
                  <div class="product-image" style="height: 120px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    @if($product->image_link)
                      <img src="{{ asset('storage/' . $product->image_link) }}" alt="{{ $product->name }}" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                    @else
                      <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-image" style="font-size: 30px; color: #ccc;"></i>
                      </div>
                    @endif
                  </div>
                  <div class="product-info">
                    <h5 style="margin-bottom: 8px; color: #333; font-size: 14px; font-weight: 600; height: 40px; overflow: hidden; line-height: 1.3;">
                      {{ \Str::limit($product->name, 40) }}
                    </h5>
                    <p style="margin-bottom: 10px; color: #e74c3c; font-weight: bold; font-size: 16px;">
                      <strong>Giá bán:</strong>
                      {{ number_format($product->discount_price ?: $product->price, 0, ',', '.') }}đ
                      @if($product->discount_price)
                        <span class="price-before-discount" style="text-decoration: line-through; color: #888; font-size: 13px; margin-left: 8px;">
                          {{ number_format($product->price, 0, ',', '.') }}đ
                        </span>
                      @endif
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                      <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary" style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; border: none; border-radius: 5px; flex: 1;">
                        Xem ngay
                      </a>
                      <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-success" style="background: linear-gradient(45deg, #27ae60, #229954); color: white; border: none; border-radius: 5px; flex: 1;">
                          <i class="fa fa-cart-plus"></i> Thêm
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <div class="col-xs-12">
                <p style="text-align: center; color: #666; font-style: italic; padding: 20px;">Chưa có sản phẩm trong danh mục này</p>
              </div>
            @endif
          </div>
          
          @if($allProducts->count() > 8)
          <div style="text-align: right; margin-top: 15px;">
            <a href="#" class="btn" style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; border: none;">
              Xem tất cả ({{ $allProducts->unique('id')->count() }} sản phẩm) <i class="fa fa-arrow-right"></i>
            </a>
          </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>
    <!-- ============================================== CATEGORIES SECTION : END ============================================== -->
 
<!-- /#top-banner-and-menu --> 
<!-- ============================================================= FOOTER ============================================================= -->
@include('partials.footerKH')
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
<script src="{{asset('assets/js/script_k.js')}}"></script>
<script src="{{asset('assets/js/do.js')}}"></script>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in position-fixed" role="alert" id="toast-success"
     style="z-index: 9999; min-width: 250px; position: fixed; bottom: 30px; right: 30px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
    {{ session('success') }}
</div>
<script>
    setTimeout(function() {
        $('#toast-success').alert('close');
    }, 3000);
</script>
@endif

<script>

</script>

<!-- Search suggestions script -->
<script src="{{asset('assets/js/search-suggestions.js')}}"></script>
</body>
</html>