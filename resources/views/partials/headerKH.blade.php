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
            <li><a href="#"><i class="fas fa-box"></i> Theo dõi đơn hàng</a></li>
            @auth
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="icon fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('customer.index') }}"><i class="fa fa-user"></i> Thông tin cá nhân</a></li>
                  <li><a href="{{ route('customer.edit') }}"><i class="fa fa-edit"></i> Chỉnh sửa thông tin</a></li>
                  <li><a href="#"><i class="fa fa-shopping-bag"></i> Đơn hàng của tôi</a></li>
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
        
        <div class="cnt-block">
          <ul class="list-unstyled list-inline">
            <li class="dropdown dropdown-small"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span class="value">VietNamese </span><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">VietNamese</a></li>
                <li><a href="#">French</a></li>
                <li><a href="#">English</a></li>
              </ul>
            </li>
          </ul>
          <!-- /.list-unstyled --> 
        </div>
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
          <div class="logo"> <a href="home"> <img src="assets/images/logo_fnn.png" alt="logo"> </a> </div>
          <!-- /.logo --> 
          <!-- ============================================================= LOGO : END ============================================================= --> </div>
        <!-- /.logo-holder -->
        
        <div class="col-xs-12 col-sm-12 col-md-5 top-search-holder"> 
          <!-- /.contact-row --> 
          <!-- ============================================================= SEARCH AREA ============================================================= -->
          <div class="search-area">
            <form>
              <div class="control-group">
                <input class="search-field" placeholder="Bạn cần tìm gì...">
                <a class="search-button" href="#"></a>
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
                <div class="basket"><i class="fas fa-shopping-cart" style="font-size:26px;color:white"></i></div>
                <div class="basket-item-count"><span class="count">{{ count(session()->get('cart', [])) }}</span></div>
              </div>
            </a>
          </div>
          
          <!-- ============================================================= SHOPPING CART LINK : END============================================================= --> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 complain"> 
          <!-- ============================================================= COMPLAIN ============================================================= -->
          <div class="complain"> 
            <a href="home"><i class='fas fa-comments' style='font-size:30px;color:white'></i></a>
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
                <li class="active dropdown yamm-fw"> <a href="home" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Home</a> </li>
                
                @foreach($parentCategories as $parentCategory)
                <li class="dropdown yamm mega-menu"> 
                  <a href="#" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">
                    {{ $parentCategory->name }}
                    @if($parentCategory->children->count() > 0)
                    <span class="menu-label hot-menu hidden-xs">hot</span>
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
                                <li><a href="#">{{ $product->name }}</a></li>
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
                
                
                <li class="dropdown  navbar-right special-menu"> <a href="#">Todays offer</a> </li>
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
</style>