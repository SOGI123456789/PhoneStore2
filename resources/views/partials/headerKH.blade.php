<header class="header-style-1"> 
  <!-- ============================================== TOP MENU ============================================== -->
  <div class="top-bar animate-dropdown">
    <div class="container">
      <div class="header-top-inner">
        <div class="cnt-account">
          <ul class="list-unstyled">
            <li><a href="#"><i class="fa fa-download"></i> Tải app</a></li>
            <li><a href="#"><i class="fas fa-map-marker-alt"></i> Hệ thống 50 cửa hàng</a></li>
            <li><a href="#"><i class="fa fa-envelope-open-o"></i> Chính sách bảo hành & đổi trả</a></li>
            <li><a href="#"><i class="fa fa-comment"></i> Góp ý & phản hồi</a></li>
            <li><a href="#"><i class="fas fa-box"></i> Theo dõi đơn hàng</a></li>
            <li><a href="{{ route('login') }}"><i class="icon fa fa-user"></i> Đăng ký/Đăng nhập</a></li>
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
          <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
          
          <div class="dropdown dropdown-cart"> <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
            <div class="items-cart-inner">
              <div class="basket"><i class="fas fa-shopping-cart" style="font-size:26px;color:white"></i></div>
              <div class="basket-item-count"><span class="count">1</span></div>
            </div>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div class="cart-item product-summary">
                  <div class="row">
                    <div class="col-xs-4">
                      <div class="image"> <a href="detail"><img src="{{asset('assets/images/cart.jpg')}}" alt=""></a> </div>
                    </div>
                    <div class="col-xs-7">
                      <h3 class="name"><a href="index.php?page-detail">Simple Product</a></h3>
                      <div class="price">$600.00</div>
                    </div>
                    <div class="col-xs-1 action"> <a href="#"><i class="fa fa-trash"></i></a> </div>
                  </div>
                </div>
                <!-- /.cart-item -->
                <div class="clearfix"></div>
                <hr>
                <div class="clearfix cart-total">
                  <div class="pull-right"> <span class="text">Sub Total :</span><span class='price'>$600.00</span> </div>
                  <div class="clearfix"></div>
                  <a href="checkout" class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a> </div>
                <!-- /.cart-total--> 
                
              </li>
            </ul>
            <!-- /.dropdown-menu--> 
          </div>
          <!-- /.dropdown-cart --> 
          
          <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= --> 
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
                
                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">Pages</a>
                  <ul class="dropdown-menu pages">
                    <li>
                      <div class="yamm-content">
                        <div class="row">
                          <div class="col-xs-12 col-menu">
                            <ul class="links">
                              <li><a href="home">Home</a></li>
                              <li><a href="category">Category</a></li>
                              <li><a href="detail">Detail</a></li>
                              <li><a href="shopping-cart">Shopping Cart Summary</a></li>
                              <li><a href="checkout">Checkout</a></li>
                              <li><a href="blog">Blog</a></li>
                              <li><a href="blog-details">Blog Detail</a></li>
                              <li><a href="contact">Contact</a></li>
                              <li><a href="sign-in">Sign In</a></li>
                              <li><a href="my-wishlist">Wishlist</a></li>
                              <li><a href="terms-conditions">Terms and Condition</a></li>
                              <li><a href="track-orders">Track Orders</a></li>
                              <li><a href="product-comparison">Product-Comparison</a></li>
                              <li><a href="faq">FAQ</a></li>
                              <li><a href="404">404</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
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