@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends('frontend')
@section('title',$setting->title)
@section('keywords',$setting->keywords)
@section('description',$setting->description)
@section('content')
    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 table-responsive-xs">
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
                                <td>
                                            @php
                                                if ($rs->isvariable==1)
                                      {
                                                echo $rs->pvname;
                                      }
                                  else
                                      {
                                                echo $rs->name;
                                      }



                                            @endphp
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


                    <div class="table-responsive-md">
                        <table class="table cart-table ">
                            <tfoot>
                            <tr>
                                <td>Total :</td>
                                <td>
                                    <h2>{{number_format($toplam, 2, ',', '.')}} €</h2>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="/" class="btn btn-solid">Alışverişe Devam ET</a></div>
                <div class="col-6"><a href="{{route('checkout')}}" class="btn btn-solid">Siparişi Tamamla</a></div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
