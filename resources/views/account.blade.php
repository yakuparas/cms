@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="profile-top">
                            <div class="profile-image">
                                <img src="{{asset("Frontend/avatar.png")}}" alt="" class="img-fluid">
                            </div>
                            <div class="profile-detail">
                                <h5>{{\Illuminate\Support\Facades\Auth::user()->name}}</h5>
                                <h6>{{\Illuminate\Support\Facades\Auth::user()->email}}</h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#info" class="nav-link active">{{__('site.profil')}}</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#address" class="nav-link">{{__('site.adres')}}</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#orderlist" class="nav-link">{{__('site.siparis')}}</a></li>
                                <li class="nav-item"><a href="" class="nav-link">{{__('site.btncikis')}}</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="info">
                            <div class="counter-section">
                                <div class="welcome-msg">
                                    <h4>{{__('site.merhaba')}}, {{\Illuminate\Support\Facades\Auth::user()->name}}</h4>

                                </div>
                                <div class="box-account box-info">

                                    <div class="col-lg-6">
                                        <form class="theme-form" action="{{route('profile-update')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="email">{{__('site.adsoyad')}}</label>
                                                <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{__('site.email')}}</label>
                                                <input type="email" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{__('site.mobile')}}</label>
                                                <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="review">{{__('site.password')}}</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <input type="submit" class="btn btn-solid" value="{{__('site.btnguncelle')}}">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="address">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Adres Listesi</h3>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#addtoadress" class="btn btn-sm btn-solid">Yeni Ekle</a>
                                            </div>

                                            <div class="address-book-section">

                                                <div class="row g-4">
                                                    @foreach($adres as $rs)
                                                        <div class="select-box col-xl-4 col-md-6">
                                                            <div class="address-box">
                                                                <div class="top">
                                                                    <h6>{{$rs->name}}</span></h6>
                                                                </div>
                                                                <div class="middle">
                                                                    <div class="address">
                                                                        {{$rs->adress}}
                                                                    </div>
                                                                    <div class="number">
                                                                        <p>PK: <span>{{$rs->postcode}}</span></p>
                                                                    </div>
                                                                </div>
                                                                <div class="bottom">
                                                                    <a href="javascript:void(0)" onclick="editadress({{$rs->id}})"  data-bs-target="#addtoadress" data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                    <a href="{{route('destroyadress',$rs->id)}}" class="bottom_btn">Sil</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="orderlist">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card dashboard-table mt-0">
                                        <div class="card-body table-responsive-sm">
                                            <div class="top-sec">
                                                <h3>My OrderList</h3>
                                            </div>
                                            <div class="table-responsive-xl">
                                                <table class="table cart-table wishlist-table">
                                                    <thead>
                                                    <tr class="table-head">
                                                        <th scope="col">Order Id</th>
                                                        <th scope="col">Payment ID</th>
                                                        <th scope="col">History</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Details</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($order as $rs)
                                                        <tr>
                                                            <td> #{{$rs->id}}</td>
                                                            <td> {{$rs->payment_id}}</td>
                                                            <td> {{$rs->history}}</td>
                                                            <td> {{$rs->payment_status}}</td>
                                                            <td> {{$rs->status}}</td>
                                                            <td>
                                                                <a href="javascript:void(0)" onclick="orderdetail({{$rs->id}})"  data-bs-target="#orderdetails" data-bs-toggle="modal" class="bottom_btn">Details</a>


                                                            </td>
                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
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
    </section>

    <div class="modal fade bd-example-modal-lg theme-modal" id="addtoadress" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <form class="theme-form modal-bg addtocart" action="{{route('createadres')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Adres Adı</label>
                                        <input type="text" class="form-control" name="name" id="name"  required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="review">Adres</label>
                                        <input type="text" name="address" class="form-control" id="adress"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="review">Post Code</label>
                                        <input type="text" name="postcode" class="form-control" id="postcode"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="review">City</label>
                                        <input type="text" name="city" class="form-control" id="city"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="review">Ülke</label>
                                        <select name="country" class="form-control" id="country">
                                            @foreach($country as $rs)

                                                <option {{ ($rs->id) == 81 ? 'selected' : '' }} value="{{$rs->id}}">{{$rs->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="review">Bölge</label>
                                        <select name="zone" class="form-control" id="zone">
                                            @foreach($zone as $rs)

                                                <option {{ ($rs->id) == 81 ? 'selected' : '' }} value="{{$rs->id}}">{{$rs->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input type="submit" class="btn btn-solid" value="Kaydet">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg theme-modal" id="orderdetails" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">

                            <div class="col-12">
                                <div class="modal-bg">
                                    <div class="offer-content">
                                        <table id="order" class="table cart-table">

                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function editadress(id)
        {
            $.ajax({
                type: 'POST',
                url: "{{route('editadress')}}",
                data:{id:id},

                success: function(results) {
                    console.log(results.country_id);
                    if (results.success === true) {
                        $('#name').val(results.name);
                        $('#adress').val(results.adress);
                        $('#city').val(results.city);
                        $('#postcode').val(results.postcode)

                        $("#country option[value=" + results.country_id + "]").prop("selected",true);
                        $("#zone option[value=" + results.zone_id + "]").prop("selected",true);


                    } else {
                        console.log("bb");
                    }
                }
            });
        }


        function orderdetail(id)
        {
            $.ajax({
                type: 'POST',
                url: "{{route('orderdetail')}}",
                data:{id:id},

                success: function(results) {
                    if (results.success === true) {

                        let order="<thead><tr><th scope='col'>Product name</th><th scope='col'>Quantity</th><th scope='col'>Price</th></tr></thead>";
                        for(let i=0;i<results.data.length;i++)
                        {
                            order+='<tr>';
                            order+='<td>';
                            order+=results.data[i]['product_name'];
                            order+='</td>';
                            order+='<td>';
                            order+=results.data[i]['quantity'];
                            order+='</td>';
                            order+='<td>';
                            order+=results.data[i]['price'];
                            order+='</td>';
                            order+='</tr>';


                        }
                        document.getElementById("order").innerHTML =order;

                    } else {
                        console.log("bb");
                    }
                }
            });
        }
    </script>
@endsection
