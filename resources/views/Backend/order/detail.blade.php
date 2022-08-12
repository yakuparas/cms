@php
    $setting=\App\Http\Controllers\HomeController::getsettings();
@endphp
@extends("Backend.layouts")
@section("title","Siparişler")
@section("content")
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3 mt-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <img src="{{asset($setting->logo)}}" alt="">
                                        <small class="float-right">Date: {{$order[0]->created_at}}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>{{$setting->company}}</strong><br>
                                        {{$setting->adress}}<br>
                                        Phone: {{$setting->phone}}<br>
                                        Email: {{$setting->email}}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{{$order[0]->uname}}</strong><br>
                                        {{$order[0]->adress}}<br>
                                        Phone: {{$order[0]->phone}}<br>
                                        Email: john.doe@example.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #{{$order[0]->payment_id}}</b><br>
                                    <br>
                                    <b>Order ID:</b> #{{$order[0]->id}}<br>
                                    <b>Payment Status:</b> {{$order[0]->payment_status}}<br>
                                    <b>Sipariş Durumu:</b> {{$order[0]->status}}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tr>
                                            <th data-width="40">#ProductID</th>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-right">Totals</th>
                                        </tr>
                                        @php
                                            $toplam=0;

                                        @endphp
                                        @foreach($data as $rs)
                                            <tr>
                                                <td>{{$rs->id}}</td>
                                                <td>{{$rs->product_name}}</td>
                                                <td>{{$rs->quantity}}</td>
                                                <td>{{$rs->price}}</td>
                                                <td>{{$rs->price*$rs->quantity}}</td>
                                            </tr>
                                            @php
                                                $toplam+=$rs->price*$rs->quantity;
                                            @endphp
                                        @endforeach

                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-4">
                                    <form method="POST" action="{{ route('admin.history.add') }}">
                                        @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sipariş Durumu</label>
                                        <input type="hidden" name="oid" value="{{$order[0]->id}}">
                                        <select name="status" id="status" class="form-control">
                                            <option value="Onay Bekliyor">Onay Bekliyor</option>
                                            <option value="Hazırlanıyor">Hazırlanıyor</option>
                                            <option value="İptal Edildi">İptal Edildi</option>
                                            <option value="Kargoya Verildi">Kargoya Verildi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Açıklama</label>
                                        <textarea id="history" class="form-control" name="history"></textarea>
                                    </div>
                                        <div class="form-group">
                                            <input class="btn btn-primary" type="submit" value="Güncelle">

                                        </div>
                                    </form>


                                </div>
                                <div class="col-4">
                                    <p class="lead">Payment Methods:</p>

                                    <img src="{{asset("images/paypal.png")}}" width="200px" alt="Paypal">
                                </div>
                                <!-- /.col -->
                                <div class="col-4">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>{{$toplam}} EUR</td>
                                            </tr>


                                            <tr>
                                                <th>Total:</th>
                                                <td>{{$toplam}} EUR</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
