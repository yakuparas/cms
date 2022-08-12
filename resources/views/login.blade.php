@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>{{__('site.login')}}</h3>
                    <div class="theme-card">
                        <form class="theme-form" action="{{route('userCheckLogin')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{__('site.email')}}</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="{{__('site.email')}}" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">{{__('site.password')}}</label>
                                <input type="password" name="password" class="form-control" id="review" placeholder="{{__('site.password')}}" required="">
                            </div>
                            <input type="submit" class="btn btn-solid" value="{{__('site.btnlogin')}}">
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>{{__('site.yenikullanici')}}</h3>
                    <div class="theme-card authentication-right">
                        <form class="theme-form" action="{{route('userRegister')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{__('site.adsoyad')}}</label>
                                <input type="text" class="form-control" name="name" id="email" placeholder="{{__('site.adsoyad')}}" required="">
                            </div>
                            <div class="form-group">
                                <label for="email">{{__('site.email')}}</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="{{__('site.email')}}" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">{{__('site.password')}}</label>
                                <input type="password" name="password" class="form-control" id="review" placeholder="{{__('site.password')}}" required="">
                            </div>
                            <input type="submit" class="btn btn-solid" value="{{__('site.btnregister')}}">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection


