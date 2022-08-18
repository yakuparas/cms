<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/Frontend/assets/images/favicon/3.png" type="image/x-icon">
    <link rel="shortcut icon" href="/Frontend/assets/images/favicon/3.png" type="image/x-icon">
    <title>@yield('title')</title>


    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/font-awesome.css">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/slick-theme.css">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/animate.css">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/themify-icons.css">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/vendors/bootstrap.css">

    <!-- Theme css -->

    <link rel="stylesheet" type="text/css" href="/Frontend/assets/css/style.css">
    @yield('css')

</head>
<body class="theme-color-1">
@include("__inc.header")
@yield('slide')
@yield('content')


<!-- footer -->

<footer class="footer-light">

    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title footer-mobile-title">
                        <h4>About</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo"><img src="{{asset($setting->logo)}}" alt=""></div>
                        <p>{{$setting->description}}</p>
                        <div class="footer-social">
                            <ul>
                                <li><a href="{{$setting->facebook}}"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="{{$setting->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="{{$setting->instagram}}"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="{{$setting->youtube}}"><i class="fa fa-youtube-play"></i></a></li>
                                <li><a href="{{$setting->linkedin}}"><i class="fa fa-linkedin-square"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col offset-xl-1">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>{{__("site.footer.information")}}</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="{{route('Page.view',['slug' => 'about'])}}">{{__("site.footer.about")}}</a></li>
                                <li><a href="{{route('Page.view',['slug' => 'delivery-information'])}}">{{__("site.footer.deliveryinformation")}}</a></li>
                                <li><a href="{{route('Page.view',['slug' => 'privacy-policy'])}}">{{__("site.footer.privacypolicy")}}</a></li>
                                <li><a href="{{route('Page.view',['slug' => 'distance-sales-contract'])}}">{{__("site.footer.distancesalescontract")}}</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>{{__("site.footer.category")}}</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                            @include("__inc.footermenu")
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>{{$setting->company}}</h4>
                        </div>
                        <div class="footer-contant">
                            <ul class="contact-list">
                                <li><i class="fa fa-map-marker"></i>{{$setting->adress}}</li>
                                <li><i class="fa fa-phone"></i>{{__('site.callus')}}: {{$setting->phone}}</li>
                                <li><i class="fa fa-mobile-phone"></i>{{__('site.mobile')}} : {{$setting->mobile}}</li>
                                <li><i class="fa fa-envelope"></i>{{__('site.email')}}: <a href="#">{{$setting->email}}</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
<!-- Add to cart modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal1">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-bg addtocart">
                                <button onclick="window.location.reload();" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="media">

                                    <div class="media-body align-self-center text-center">
                                        <a href="#">
                                            <h6 >
                                                <i class="fa fa-exclamation-circle"></i>

                                                <span id="msj" > </span>
                                            </h6>
                                        </a>
                                        <div class="buttons">
                                            <a href="#" class="view-cart btn btn-solid">Sepeti Görüntüle</a>
                                            <a href="#" onclick="window.location.reload();" class="continue btn btn-solid" data-bs-dismiss="modal" aria-label="Close">Alışverişe Devam Et</a>
                                        </div>

                                        <div class="upsell_payment">
                                            <img src="../assets/images/payment_cart.png" class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="product-section">
                                    <div class="col-12 product-upsell text-center">
                                        <h4>Son Eklenen Ürünler</h4>
                                    </div>
                                    <div class="row" id="upsell_product">
                                        @yield('lastmodal')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tap to top -->
<div class="tap-top">
    <div><i class="fa fa-angle-double-up"></i></div>
</div>
<!-- tap to top End -->


<!-- latest jquery-->
<script src="/Frontend/assets/js/jquery-3.3.1.min.js"></script>

<!-- menu js-->
<script src="/Frontend/assets/js/menu.js"></script>

<!-- lazyload js-->
<script src="/Frontend/assets/js/lazysizes.min.js"></script>

<!-- slick js-->
<script src="/Frontend/assets/js/slick.js"></script>

<!-- Bootstrap js-->
<script src="/Frontend/assets/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Notification js-->
<script src="/Frontend/assets/js/bootstrap-notify.min.js"></script>

<!-- Theme js-->
<script src="/Frontend/assets/js/script.js"></script>

@yield("js")
<script>

    $(window).on('load', function () {

        function openSearch() {
            alert("aa");
            document.getElementById("search-overlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
        setTimeout(function () {
            $('#exampleModal').modal('show');
        }, 2500);



    });

</script>
</body>

</html>