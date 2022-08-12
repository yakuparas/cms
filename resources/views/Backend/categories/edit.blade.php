@php
    $catList=\App\Http\Controllers\Backend\CategoryController::CatList();
@endphp
@extends("Backend.layouts")
@section("title","Kategori Düzenleme")

@section("content")
    <div class="content-wrapper pt-2" >
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 create">
                        <form action="#" method="POST" id="edit_category" enctype="multipart/form-data">
                            @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kategori Düzenle</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Kategori Adı</label>
                                    <input type="text"  class="form-control" value="{{$data->title}}" name="title" id="title" placeholder="Kategori Adı">
                                    <input type="hidden" name="catid" id="catid" value="{{$data->id}}">
                                </div>

                                <div class="form-group">
                                    <label for="title">Alt Kategori</label>
                                    <select name="parent" class="form-control">
                                        <option value="0">Anakategori</option>
                                        {{$data->parent_id}}
                                        @foreach ($cat as $rs )
                                            <option value="{{ $rs->id }}" @if($rs->id == $data->parent_id) selected @endif >{{\App\Http\Controllers\Backend\CategoryController::getParentsTree($rs,$rs->title)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Kategori Resmi</label>

                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Resim Seç</label>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <img width="100" src="{{$data->image}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title">Açıklama</label>
                                    <textarea name="description" id="summernote">{{$data->description}}
                                     </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="title">Keywords</label>
                                    <input type="text" class="form-control" value="{{$data->keywords}}" name="keywords" id="keywords" placeholder="Keywords">
                                </div>
                                <div class="form-group">
                                    <input id="status" type="checkbox" data-on-text="Aktif" data-off-text="Pasif" name="status" @if (1 == $data->status)
                                        checked
                                           @endif data-bootstrap-switch>

                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" value="Güncelle">

                            </div>

                            <!-- /.card-footer-->
                        </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kategori Listesi</h3>
                            </div>
                            <div class="card-body">


                                <ul style="list-style-type: none">

                            @foreach($catList as $rs)
                                            <li>{{$rs->title}} | <a href="{{route("Category.edit",["id"=>$rs->id])}}"><i  class="fas fa-pen fa-xs"></i></a> | <i onclick="categoridelete({{$rs->id}})" class="fas fa-trash fa-xs"></i>
                                                @if(count($rs->children))
                                                    @include('Backend.inc.__categorytree',['children'=>$rs->children])
                                                @endif
                                            </li>

                                        @endforeach
                                    </ul>




                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{route("Category.index")}}" class="btn btn-primary">Kategori Ekle</a>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                    </div>
                </div>
            </div>




        </section>
    </div>
@endsection
@section("js")

    <script>

        $(function () {
            bsCustomFileInput.init();
            $('#summernote').summernote();
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });




        });



        function categoridelete(id)
        {
            alert(id);
        }


        let status="";
        $( document ).ready(function() {

            if ($('#status').bootstrapSwitch('state')==true)
                status=1;
            else
                status=0;
        });



        var spinner = $('#loader');
        $("#status").bootstrapSwitch({
            onSwitchChange: function(e, state) {
               if (state==true)
                   status=1;
                else
                    status=0;
            }
        });




        $("#edit_category").submit(function(e) {


            spinner.show();
            e.preventDefault();
            const fd = new FormData(this);
            fd.append('status', status);
            for (const value of fd.values()) {

            }

            $.ajax({
                url: '{{route("Category.update")}}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $("#edit_category")[0].reset();
                    spinner.hide();
                    location.reload();

                }
            });
        });



    </script>
@endsection
