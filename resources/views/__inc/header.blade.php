@php
    $catList=\App\Http\Controllers\HomeController::CatList();
    $setting=\App\Http\Controllers\HomeController::getsettings();
        $getCart=\App\Http\Controllers\HomeController::getCart();

@endphp
<header class="header-tools zindex-up header-style top-relative">
    <div class="mobile-fix-option"></div>
    <div class="logo-menu-part">
        <div class="container container-lg border-bottom-0 rounded-5">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-menu">
                        <div class="menu-left">
                            <div class="brand-logo">
                                <a href="/"> <img src="{{asset($setting->logo)}}" class="img-fluid blur-up lazyload" alt=""></a>
                            </div>
                        </div>
                        <div class="menu-right pull-right">
                            <div>
                                <nav id="main-nav">
                                    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                        <li>
                                            <div class="mobile-back text-end">Geri<i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                        </li>
                                        <li><a href="/">{{__('site.menu.anasayfa')}}</a></li>


                                        @foreach($catList as $rs)
                                            <li><a href="{{route('categoryproducts',['id'=>$rs->id,'slug'=>$rs->seo_url])}}">{{$rs->title}}</a>
                                                @if(count($rs->children))
                                                    @include('__inc.__categorytree',['children'=>$rs->children])
                                                @endif
                                            </li>

                                        @endforeach
                                        <li><a href="{{route('zaunplanner')}}">{{__('site.menu.planner')}}</a></li>



                                    </ul>
                                </nav>
                            </div>
                            <div class="top-header">
                                <ul class="header-dropdown">
                                    <li class="onhover-dropdown mobile-account">
                                        <img src="/Frontend/assets/images/icon/user-1.png" alt="">
                                        <ul class="onhover-show-div">
                                        @guest
                                            {{__('site.Hesabım')}}

                                                <li><a href="{{route('Userlogin')}}">{{__('site.menu.girisyap')}}</a></li>
                                                <li><a href="">{{__('site.menu.uyeol')}}</a></li>

                                        @endguest
                                        @auth
                                            {{Auth::user()->name}}
                                                <li><a href="{{route('profile')}}">{{__('site.menu.hesabim')}}</a></li>
                                                <li><a href="{{route('logout')}}">{{__('site.menu.cikisyap')}}</a></li>

                                        @endauth
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div class="icon-nav">
                                    <ul>




                                        <li class="onhover-div mobile-cart">
                                            <div>
                                                <a href="{{route('cart.show',[auth()->check() ? auth()->id() : session()->getId()])}}">

                                                <img src="/Frontend/assets/images/icon/cart-1.png" class="img-fluid blur-up lazyload" alt="">
                                                <i class="ti-shopping-cart"></i>
                                                <span class="cart_qty_cls">{{count($getCart)}}</span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->