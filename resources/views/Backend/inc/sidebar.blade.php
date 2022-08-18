<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route("Backend.dashboard")}}" class="brand-link">
        <img src="{{asset("logo.jpg")}}" width="75px"  class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">




        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route("Backend.dashboard")}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>                      <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("Category.index")}}" class="nav-link">
                        <i class=" nav-icon fab fa-trello"></i>                        <p>
                            Kategori Yönetimi
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Ürün Yönetimi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route("Product.index")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ürünler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route("Product.create")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ürün Ekle</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route("Slider.list")}}" class="nav-link">
                        <i class="nav-icon fas fa-images"></i>                        <p>
                            Slider Yönetimi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("Page.list")}}" class="nav-link">
                        <i class="nav-icon fas fa-paper-plane"></i>                        <p>
                           Sayfa Yönetimi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-blog"></i>                       <p>
                            Blog Yönetimi
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route("admin.order")}}" class="nav-link">
                        <i class="nav-icon fas fa-luggage-cart"></i>                        <p>
                            Sipariş Yönetimi
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>                        <p>
                            Müşteri Yönetimi
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('Setting.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-sliders-h"></i>                        <p>
                            Mağaza Ayarları
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/languages" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-language"></i>                        <p>
                            Dil Çevirileri
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
