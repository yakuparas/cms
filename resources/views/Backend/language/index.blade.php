@extends("Backend.layouts")
@section("title","Slider")
@section("content")
    <div class="content-wrapper">
        <div class="content pt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{route('Slider.create')}}" class="btn btn-primary">Slide Ekle</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-striped">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
