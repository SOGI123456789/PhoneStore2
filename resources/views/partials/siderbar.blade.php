<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('adminlte3.0/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminlte3.0/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <
                @if(auth()->check())
                    @php $roleId = auth()->user()->role_id ?? 0; @endphp
                    @if($roleId == 1)
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Danh mục sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('menus.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Quản lý menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Quản lý sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Phân quyền</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Quản lý đơn hàng</p>
                            </a>
                        </li>
                    @elseif($roleId == 3)
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Quản lý giao hàng</p>
                            </a>
                        </li>
                    @elseif($roleId == 4)
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Quản lý đơn hàng</p>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
