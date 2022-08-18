@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
    $lastmodal=\App\Http\Controllers\HomeController::lastmodal();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')

    <!-- about section start -->
    <section class="about-page section-b-space">
        <div class="container">
            <div class="row">

                <div class="col-sm-12">
                    <h4>{{$data[0]['title']}}
                    </h4>

                    {!! $data[0]['description'] !!}

                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->
@endsection