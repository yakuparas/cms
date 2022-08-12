@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)

@section('content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">

                    </div>
                </div>
                <div class="col-sm-6">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                            <li class="breadcrumb-item"><a href="#">{{\App\Http\Controllers\Backend\CategoryController::getParentsTree($cat,$cat->title)}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->
    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="top-banner-wrapper">
                                        <a href="#"><img src="{{$cat->image}}" class="img-fluid blur-up lazyload" alt=""></a>
                                        <div class="top-banner-content small-section">
                                            <h4>{{$cat->title}}</h4>
                                            <p>{!! $cat->description !!} </p>
                                        </div>
                                    </div>
                                    <section class="pt-0 section-b-space ratio_asos">
                                        <div class="container">
                                            <div class="row game-product grid-products">
                                                @foreach($data as $rs)

                                                    <div class="product-box col-xl-2 col-lg-3 col-sm-4 col-6">
                                                        <div class="img-wrapper">
                                                            <div class="front">
                                                                <a href="{{route('product-detail',['name'=>$rs->slug,'id'=>$rs->id])}}"><img src="{{$rs->image}}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                                            </div>

                                                        </div>
                                                        <div class="product-detail">
                                                            <a href="{{route('product-detail',['name'=>$rs->slug,'id'=>$rs->id])}}">
                                                                <h6>{{$rs->name}}</h6>
                                                            </a>
                                                            <h4>

                                                                @if($rs->discount_price != null)
                                                                    {{$rs->discount_price}}
                                                                    <del>{{$rs->price}}</del>
                                                                @else
                                                                    {{$rs->price}}
                                                                @endif
                                                            </h4>
                                                        </div>
                                                    </div>


                                                @endforeach

                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section End -->
@endsection


