<header class="header-style-1"> 
  <!-- ============================================== TOP MENU ============================================== -->
  <div class="top-bar animate-dropdown">
    <div class="container">
      <div class="header-top-inner">
        <div class="cnt-account">
          <ul class="list-unstyled">
            <li><a href="#"><i class="fas fa-map-marker-alt"></i> Hệ thống 50 cửa hàng</a></li>
            <li><a href="#"><i class="fa fa-envelope-open-o"></i> Chính sách bảo hành & đổi trả</a></li>
            <li><a href="#"><i class="fa fa-comment"></i> Góp ý & phản hồi</a></li>
            @auth
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="icon fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('customer.index') }}"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                  <li><a href="{{ route('customer.edit') }}"><i class="fa fa-edit"></i> Chỉnh sửa thông tin</a></li>
                  <li><a href="{{ route('customer.orders') }}"><i class="fa fa-shopping-bag"></i> Đơn hàng của tôi</a></li>
                  <li role="separator" class="divider"></li>
                  <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </li>
            @else
              <li><a href="{{ route('login') }}"><i class="icon fa fa-user"></i> Đăng ký/Đăng nhập</a></li>
            @endauth
          </ul>
        </div>
        <!-- /.cnt-account -->
       
        <!-- /.cnt-cart -->
        <div class="clearfix"></div>
      </div>
      <!-- /.header-top-inner --> 
    </div>
    <!-- /.container --> 
  </div>
  <!-- /.header-top --> 
  <!-- ============================================== TOP MENU : END ============================================== -->
  <div class="main-header">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 logo-holder"> 
          <!-- ============================================================= LOGO ============================================================= -->
          <div class="logo"> 
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height:50px;">
            </a>
          </div>
          <!-- /.logo --> 
          <!-- ============================================================= LOGO : END ============================================================= --> </div>
        <!-- /.logo-holder -->
        
        <div class="col-xs-12 col-sm-12 col-md-5 top-search-holder"> 
          <!-- /.contact-row --> 
          <!-- ============================================================= SEARCH AREA ============================================================= -->
          <div class="search-area">
            <form action="{{ route('search') }}" method="GET">
              <div class="control-group">
                <input class="search-field" name="q" placeholder="Bạn cần tìm gì..." value="{{ request('q') }}" 
                       id="searchInput" autocomplete="off" required>
                <button type="submit" class="search-button">
                </button>
                <div id="searchSuggestions" class="search-suggestions"></div>
              </div>
            </form>
          </div>
          <!-- /.search-area --> 
          <!-- ============================================================= SEARCH AREA : END ============================================================= --> </div>
        <!-- /.top-search-holder -->
        
        <div class="col-xs-12 col-sm-12 col-md-1 animate-dropdown top-cart-row"> 
          <!-- ============================================================= SHOPPING CART LINK ============================================================= -->
         
          <div class="cart-link"> 
            <a href="{{ route('shopping-cart') }}" class="lnk-cart">
                <div class="items-cart-inner">
                    <div class="basket">
                        <img src="{{ asset('assets/images/shopping-cart.png') }}" alt="Giỏ hàng" style="height:26px;">
                    </div>
                    
                </div>
            </a>
          </div>
          
          <!-- ============================================================= SHOPPING CART LINK : END============================================================= --> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 complain"> 
          <!-- ============================================================= COMPLAIN ============================================================= -->
          <div class="complain"> 
            
            <div class="content-complain">
              <span class="text-complain">Khiếu nại</br></span>
              <span class="phone-complain">0123456789</span>
            </div>
          </div>
          <!-- /.logo --> 
          <!-- ============================================================= COMPLAIN : END ============================================================= --> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 hotline"> 
        <!-- ============================================================= HOTLINE ============================================================= -->
          <div class="hotline"> 
            <a href="home"><i class="fas fa-phone-alt" style="font-size:30px;color:white"></i></a>
            <div class="content-hotline">
              <span class="text-hotline">Hotline bán hàng</br></span>
              <span class="phone-hotline">0909 2323</span>
            </div>
          </div>
        <!-- /.logo --> 
        <!-- ============================================================= HOTLINE : END ============================================================= -->
        </div>
        <div class="col-xs-12 col-sm-12 col-md-1 technology"> 
          <!-- ============================================================= TECHNOLOGY ============================================================= -->
            <div class="technology"> 
              <a href="home"><i class="fas fa-headset" style="font-size:30px;color:white"></i></a>
              <div class="content-technology">
                <span class="text-technology">Tư vấn kỹ thuật</br></span>
                <span class="phone-technology">0909 1214</span>
              </div>
            </div>
          <!-- /.logo --> 
          <!-- ============================================================= TECHNOLOGY : END ============================================================= -->
        </div>
        <!-- /.top-cart-row --> 
      </div>
      <!-- /.row --> 
      
    </div>
    <!-- /.container --> 
    
  </div>
  <!-- /.main-header --> 
  
  <!-- ============================================== NAVBAR ============================================== -->
  <div class="header-nav animate-dropdown">
    <div class="container">
      <div class="yamm navbar navbar-default" role="navigation">
        <div class="navbar-header">
       <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
       <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div class="nav-bg-class">
          <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
            <div class="nav-outer">
              <ul class="nav navbar-nav">
                <li class="active dropdown yamm-fw"> <a href="{{ url('/') }}" >Home</a> </li>
                
                @foreach($parentCategories as $parentCategory)
                <li class="dropdown yamm mega-menu"> 
                  <a href="#" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">
                    {{ $parentCategory->name }}
                    @if($parentCategory->children->count() > 0)
                  
                    @endif
                  </a>
                  
                  @if($parentCategory->children->count() > 0)
                  <ul class="dropdown-menu container">
                    <li>
                      <div class="yamm-content ">
                        <div class="row">
                          @foreach($parentCategory->children->chunk(4) as $chunk)
                          @foreach($chunk as $childCategory)
                          <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                            <h2 class="title">{{ $childCategory->name }}</h2>
                            <ul class="links">
                              @if($childCategory->products->count() > 0)
                                @foreach($childCategory->products->take(5) as $product)
                                <li><a href="{{ route('product.detail', ['id' => $product->id]) }}">{{ $product->name }}</a></li>
                                @endforeach
                              @else
                                <li><a href="#">Đang cập nhật...</a></li>
                              @endif
                            </ul>
                          </div>
                          @endforeach
                          @endforeach
                          
                          <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image"> 
                            <img class="img-responsive" src="{{asset('assets/images/banners/top-menu-banner.jpg')}}" alt=""> 
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  @endif
                </li>
                @endforeach
                
                
               
              </ul>
              <!-- /.navbar-nav -->
              <div class="clearfix"></div>
            </div>
            <!-- /.nav-outer --> 
          </div>
          <!-- /.navbar-collapse --> 
          
        </div>
        <!-- /.nav-bg-class --> 
      </div>
      <!-- /.navbar-default --> 
    </div>
    <!-- /.container-class --> 
    
  </div>
  <!-- /.header-nav --> 
  <!-- ============================================== NAVBAR : END ============================================== --> 
  
</header>
<style>
.dropdown-menu {
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.dropdown-menu li a {
    color: #333 !important;
    padding: 8px 15px;
    display: block;
}

.dropdown-menu li a:hover {
    background: #f5f5f5;
    color: #333 !important;
}

.dropdown-menu .divider {
    height: 1px;
    margin: 5px 0;
    background: #e5e5e5;
}

.basket img {
    margin-top: 8px;
    margin-left: 8px;
}
.search-area {
    position: relative;
}

.search-area {
    position: relative;
}

.control-group {
    position: relative;
    width: 100%;
}

.search-field {
    width: 100%;
    padding-right: 50px;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding-left: 15px;
}

.search-button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    color: #666;
    height: 30px;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-button:hover {
    color: #333;
    background: #f5f5f5;
    border-radius: 3px;
}

.search-button i {
    font-size: 16px;
}

/* Search suggestions dropdown */
.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-top: none;
    border-radius: 0 0 4px 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 9999 !important;
    max-height: 300px;
    overflow-y: auto;
    display: none;
}

.search-suggestion-item {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    display: flex;
    align-items: center;
}

.search-suggestion-item:hover {
    background: #f8f9fa;
}

.search-suggestion-item.active {
    background: #e3f2fd;
}

.search-suggestion-item:last-child {
    border-bottom: none;
}

.search-suggestion-item .suggestion-icon {
    margin-right: 10px;
    color: #666;
}

.search-suggestion-item .suggestion-text {
    flex: 1;
}

.search-suggestion-item .suggestion-type {
    font-size: 12px;
    color: #999;
    margin-left: 10px;
}
</style>
