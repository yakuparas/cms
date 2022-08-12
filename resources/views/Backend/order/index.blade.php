@extends("Backend.layouts")
@section("title","Siparişler")
@section("content")
    <div class="content-wrapper">
        <div class="content pt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive table-striped">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">
                                                OrderID
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Tracking No</th>
                                            <th>Zone</th>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                            <th>Status</th>
                                            <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($data as $rs)
                                            <tr>
                                                <td>{{$rs->id}}</td>
                                                <td>{{$rs->uname}}</td>
                                                <td>{{$rs->email}}</td>
                                                <td>{{$rs->tracking}}</td>
                                                <td>{{$rs->zone}}</td>
                                                <td>{{$rs->amount}}</td>
                                                <td>{{$rs->payment_status}}</td>
                                                <td>{{$rs->status}}</td>
                                                <td><a href="{{route('admin.orderdetail',['id'=>$rs->id])}}">Details</a></td>
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
@endsection

@section('js')
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": true
            }]
        });

    </script>
@endsection