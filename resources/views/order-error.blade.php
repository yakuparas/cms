@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')

    <!-- thank-you section start -->
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="success-text">
                        <div class="checkmark">
                            <img src="/public/images/crossmark.png" width="100" alt="">
                        </div>
                        <h2>!! Error !!</h2>
                        <p>{{$msj}}</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection
