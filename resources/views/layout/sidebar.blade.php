<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link link-offset-3">
        <img src="{{asset('images/logo.webp')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text ">Handmade Gifts</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if($userData && $userData->media)
                    <img src="{{asset('images/users/' . $userData->media->file_name  ) }}"
                         class="img-circle elevation-2 object-fit-cover" style="width:40px; height: 40px; "
                         alt="User Image">
                @else
                    <img src="{{asset('images/default-user.webp')}}" class="img-circle elevation-2"
                         alt="User Image">
                @endif

            </div>

            <div class="info">
                @if($userData)
                    <a href="" class="d-block link-offset-2">{{$userData->username }}</a>
                @else
                    <a href="" class="d-block link-offset-2">Guest</a>
                @endif
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input name="search" class="form-control form-control-sidebar" type="search" placeholder="Search"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li>
                    <a href="{{route('category')}}"
                       class="nav-link {{Request::url()==route('category') ? "active" : ""}}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Category
                        </p>
                    </a>
                </li>

                <li>
                    <a href="{{route('brand')}}"
                       class="nav-link {{Request::url()==route('brand') ? "active" : ""}}">
                        <i class="fa-regular fa-copyright"></i>
                        <p>
                            Brand
                        </p>
                    </a>
                </li>

                <li>
                    <a href="{{route('product')}}"
                       class="nav-link {{Request::url()==route('product') ? "active" : ""}}">
                        <i class="fa-brands fa-product-hunt"></i>
                        <p>
                            Product
                        </p>
                    </a>
                </li>

                @if($userData && $userData->is_admin==1)
                    <li>
                        <a href="{{route('user')}}"
                           class="nav-link {{Request::url()==route('user') ? "active" : ""}}">
                            <i class="fa-solid fa-user"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
