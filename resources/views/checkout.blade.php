@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')

    <!-- section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form action="{{ route('paypal.charge') }}" method="post">

                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-xs-6">
                            <div class="checkout-title">

                                <a href="http://127.0.0.1:8000/cart/checkout" class="btn btn-solid btn-xs">Adres Ekle</a>
                            </div>

                            @if(count($adres)>0)
                                <div class="row check-out">
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Adres Adı</div>
                                        <select name="aname" id="aname">
                                            @foreach($adres as $rs)
                                                <option value="{{$rs->id}}">{{$rs->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-126 col-xs-12">
                                        <div class="field-label">Adres</div>
                                        <input type="text" disabled name="adress" id="adress" value="{{$adres[0]['adress']}}" placeholder="">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-126 col-xs-12">
                                        <div class="field-label">Post Code</div>
                                        <input type="text" disabled name="postcode" id="postcode" value="{{$adres[0]['postcode']}}" placeholder="">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-126 col-xs-12">
                                        <div class="field-label">City</div>
                                        <input type="text" disabled name="city" id="city" value="{{$adres[0]['city']}}" placeholder="">
                                    </div>


                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Country</div>
                                        <select disabled name="country" class="form-control" id="country">
                                            @foreach($country as $rs)

                                                <option {{ ($rs->id) == 81 ? 'selected' : '' }} value="{{$rs->id}}">{{$rs->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Bölge</div>
                                        <select disabled name="zone" class="form-control" id="zone">
                                            @foreach($zone as $rs)

                                                <option {{ ($rs->id) == 81 ? 'selected' : '' }} value="{{$rs->id}}">{{$rs->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-8 col-sm-12 col-xs-12">
                            <div class="order-box">
                            <table class="table cart-table">
                                <thead>
                                <tr class="table-head">
                                    <th scope="col">İmage</th>
                                    <th scope="col">Produck Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Sub Total</th>
                                </tr>
                                </thead>

                                @php
                                    $toplam=0;
                                @endphp



                                @foreach($data as $rs)




                                    @php
                                        if ($rs->isvariable==1)
                                            {
                                                $price=isset($rs->pvdprice)?$rs->pvdprice:$rs->pvprice;
                                                $toplam=$toplam+($price*$rs->quantity);
                                            }
                                        else
                                            {
                                                $price=isset($rs->discount_price)?$rs->discount_price:$rs->price;
                                                $toplam=$toplam+($price*$rs->quantity);
                                            }

                                    @endphp

                                    <tr>
                                        <td>
                                            @php
                                                if ($rs->isvariable==1)
                                      {
                                                  echo '<img width="50" src="'.$rs->pvimage.'" alt="">';
                                      }
                                  else
                                      {
                                                  echo '<img width="50" src="'.$rs->image.'" alt="">';
                                      }



                                            @endphp

                                        </td>
                                        <td>         @php
                                                if ($rs->isvariable==1)
                                      {
                                                echo $rs->pvname;
                                      }
                                  else
                                      {
                                                echo $rs->name;
                                      }



                                            @endphp<br>





                                        </td>
                                        <td>{{ number_format($price, 2, ',', '.')}} €</td>
                                        <td>
                                            <div class="qty-box">
                                                <div class="input-group" style="justify-content:center !important;">
                                                    <input type="number" name="quantity" class="form-control input-number" value="{{$rs->quantity}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{number_format(($price*$rs->quantity), 2, ',', '.')}} €</td>

                                    </tr>
                                @endforeach



                            </table>

                            </div>

                            <div class="payment-box">
                                <div class="upper-box">
                                    <div class="payment-options">
                                        <ul>
                                            <li>
                                                <b> Total  {{number_format($toplam, 2, ',', '.')}} €</b>
                                            </li>
                                            <li>
                                                <div class="radio-option paypal">
                                                    <input type="radio" checked name="payment-group" id="payment-3">
                                                    <label for="payment-3">PayPal<span class="image"><img src="/frontend/assets/images/paypal.png" alt=""></span></label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-end">

                                    <input type="hidden"  value="{{number_format($toplam, 2, '.', '');}}" name="amount" />
                                    {{ csrf_field() }}
                                    <input type="submit" class="btn-solid btn" name="submit" value="Paypal">

                                </div>

                            </div>

                        </div>


                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#aname').on('change', function() {


            $.ajax({
                type: 'POST',
                url: "{{route('editadress')}}",
                data:{id:this.value},

                success: function(results) {

                    if (results.success === true) {
                        $('#adress').val(results.adress);
                        $('#city').val(results.city);
                        $('#postcode').val(results.postcode)

                        $("#country option[value=" + results.country_id + "]").prop("selected",true);
                        $("#zone option[value=" + results.zone_id + "]").prop("selected",true);


                    }
                }
            });
        });
    </script>
@endsection
