<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="PhoneStore, Điện thoại, Smartphone">
    <meta name="robots" content="all">

    <title>Kết quả tìm kiếm: {{ $query }} - PhoneStore</title>

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

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    
    <!-- Search specific CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">

    <!-- Fonts --> 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>

<body class="cnt-home">
    <!-- HEADER -->
    @include('partials.headerKH')
    <!-- HEADER END -->

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('index') }}">Trang chủ</a></li>
                    <li class='active'>Kết quả tìm kiếm</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB END -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <!-- SIDEBAR -->
                <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
                    
                    <!-- SEARCH FILTERS -->
                    <div class="sidebar-widget">
                        <h3 class="section-title">Lọc kết quả</h3>
                        <form method="GET" action="{{ route('search') }}">
                            <input type="hidden" name="q" value="{{ $query }}">
                            
                            <!-- Category Filter -->
                            <div class="sidebar-widget-body">
                                <div class="accordion">
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapse-category" data-toggle="collapse" class="accordion-toggle collapsed">
                                                Danh mục
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapse-category">
                                            <div class="accordion-inner">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="category_id" value="" {{ empty($categoryId) ? 'checked' : '' }}>
                                                            Tất cả danh mục
                                                        </label>
                                                    </li>
                                                    @foreach($categories as $category)
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="category_id" value="{{ $category->id }}" 
                                                                {{ $categoryId == $category->id ? 'checked' : '' }}>
                                                            {{ $category->name }}
                                                        </label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div class="sidebar-widget-body">
                                <div class="accordion">
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapse-sort" data-toggle="collapse" class="accordion-toggle collapsed">
                                                Sắp xếp theo
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapse-sort">
                                            <div class="accordion-inner">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="sort_by" value="newest" {{ $sortBy == 'newest' ? 'checked' : '' }}>
                                                            Mới nhất
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="sort_by" value="price_asc" {{ $sortBy == 'price_asc' ? 'checked' : '' }}>
                                                            Giá thấp đến cao
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="sort_by" value="price_desc" {{ $sortBy == 'price_desc' ? 'checked' : '' }}>
                                                            Giá cao đến thấp
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="sort_by" value="name" {{ $sortBy == 'name' ? 'checked' : '' }}>
                                                            Tên A-Z
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="sort_by" value="popular" {{ $sortBy == 'popular' ? 'checked' : '' }}>
                                                            Phổ biến nhất
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Áp dụng bộ lọc</button>
                        </form>
                    </div>
                    <!-- SEARCH FILTERS END -->

                </div>
                <!-- SIDEBAR END -->

                <!-- MAIN CONTENT -->
                <div class="col-xs-12 col-sm-12 col-md-9">
                    
                    <!-- SEARCH RESULTS HEADER -->
                    <div class="search-result-container">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active" id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="search-result-header">
                                                <h3>Kết quả tìm kiếm cho: "<span class="text-primary">{{ $query }}</span>"</h3>
                                                <p>Tìm thấy {{ $products->total() }} sản phẩm</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($products->count() > 0)
                                    <!-- PRODUCTS GRID -->
                                    <div class="row">
                                        @foreach($products as $product)
                                        <div class="col-sm-6 col-md-4 col-lg-4">
                                            <div class="item item-carousel">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="{{ route('product.detail', $product->id) }}">
                                                                    <img src="{{ $product->image_link ? asset('storage/' . $product->image_link) : asset('assets/images/default-product.jpg') }}" 
                                                                         alt="{{ $product->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="product-info text-left">
                                                            <h3 class="name">
                                                                <a href="{{ route('product.detail', $product->id) }}">
                                                                    {{ \Str::limit($product->name, 40) }}
                                                                </a>
                                                            </h3>
                                                            
                                                            <div class="rating rateit-small"></div>
                                                            
                                                            <div class="description"></div>
                                                            
                                                            <div class="product-price">
                                                                <span class="price">
                                                                    {{ number_format($product->discount_price ?: $product->price, 0, ',', '.') }}đ
                                                                </span>
                                                                @if($product->discount_price)
                                                                <span class="price-before-discount">
                                                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                            <input type="hidden" name="quantity" value="1">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                    <li class="lnk wishlist">
                                                                        <a class="add-to-cart" href="#" title="Yêu thích">
                                                                            <i class="icon fa fa-heart"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="lnk">
                                                                        <a class="add-to-cart" href="{{ route('product.detail', $product->id) }}" title="Xem nhanh">
                                                                            <i class="icon fa fa-eye"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- PRODUCTS GRID END -->

                                    <!-- PAGINATION -->
                                    <div class="clearfix filters-container">
                                        <div class="text-right">
                                            <div class="pagination-container">
                                                {{ $products->appends(request()->query())->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PAGINATION END -->

                                    @else
                                    <!-- NO RESULTS -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="no-results text-center" style="padding: 60px 0;">
                                                <i class="fa fa-search" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                                                <h3>Không tìm thấy sản phẩm nào</h3>
                                                <p>Thử tìm kiếm với từ khóa khác hoặc xem các sản phẩm khác</p>
                                                <a href="{{ route('index') }}" class="btn btn-primary">Về trang chủ</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NO RESULTS END -->
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MAIN CONTENT END -->
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    @include('partials.footerKH')
    <!-- FOOTER END -->

    <!-- JavaScripts -->
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
    <script src="{{ asset('assets/js/search.js') }}"></script>

</body>
</html>
