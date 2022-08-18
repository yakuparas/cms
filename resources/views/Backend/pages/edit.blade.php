@extends("Backend.layouts")
@section("title","Sayfa Düzenleme")
@section("content")
    <div class="content-wrapper">
        <div class="content pt-2">
            <form method="POST"  action="{{route('Page.update',$data["id"])}}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{route('Page.list')}}" class="btn btn-outline-primary">Sayfa Listesi</a>
                                    <input type="submit" class="btn btn-outline-success" value="Güncelle">
                                </h3>
                            </div>
                            <!-- /.card-header -->


                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Başlık</label>
                                            <input name="title" value=" {{$data->title}}" type="text" required id="title" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Slug</label>
                                            <input name="slug" value=" {{$data->slug}}" type="text"  id="title" class="form-control">

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">İçerik</label>
                                            <textarea name="description" id="summernote">
                                         {{$data->description}}
                                </textarea>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-outline-success" value="Güncelle">

                            </div>

                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </form>
        </div>
    </div>
@endsection
@section("js")
    <script>
        $(function() {
            $('#summernote').summernote({
                height: 500

            });

        });
    </script>
@endsection
