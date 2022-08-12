@extends("Backend.layouts")
@section("title","Ürün Ekle")

@section("content")
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Seçenek Ekle</h3>
                                <div class="card-tools">

                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <form action="{{route("ProductOptions.add")}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Seçenek Adı <b style="color: red">(*)</b> </label>
                                        <input type="text" required class="form-control" name="optionsName">
                                    </div>
                                    <div class="form-group">
                                        <label for="Seçenek Değerleri">Seçenek Değerleri <b style="color: red">(*)</b> </label>
                                        <input type="text" required class="form-control" data-role="tagsinput" name="optionsValue">
                                    </div>
                                    <input type="hidden" name="pid" id="pid" value="{{$pid}}">

                                    <input type="submit" class="btn btn-primary" value="Ekle">
                                </div>
                            </form>

                            <div class="card-footer">
                                <form action="{{route("ProductVariants.combinaton")}}" method="post">
                                    @csrf
                                <input type="hidden" name="prid" id="prid" value="{{$pid}}">
                                <input type="hidden" name="name" id="name" value="{{$name}}">
                                <input type="hidden" name="slug" id="slug" value="{{$slug}}">
                                    <input type="submit" class="btn btn-info btn-block" value="Varyant Oluştur">
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.col-md-6 -->
                    @foreach($options as $rs)
                        <div class="col-md-3">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">{{$rs->name}}</h3>

                                    <div class="card-tools">
                                        <button type="button" data-toggle="tooltip" title="Seçenek Güncelle" onclick="optionedit({{$rs->id}})"  class="btn btn-tool"> <i class="fas fa-pen fa"></i>
                                        </button>
                                        <button type="button" data-toggle="tooltip" title="Seçenek Sil" onclick="optiondelete({{$rs->id}})"  class="btn btn-tool">
                                            <i   class="fas fa-trash fa"></i>
                                        </button>
                                        <button type="button" data-toggle="tooltip" title="Seçenek Değer Ekle" onclick="optionadd({{$rs->id}})"  class="btn btn-tool">
                                            <i   class="fas fa-plus-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <ul style="list-style-type: none; margin-left: 2px">
                                        @foreach($rs->optionsValues as $v)
                                            <li><button type="button" data-toggle="tooltip" title="Seçenek Sil" onclick="optionvaluedelete({{$v->id}})"  class="btn btn-tool">
                                                    <i  class="fas fa-trash fa"></i>
                                                </button>{{$v->name}}   </li>
                                        @endforeach
                                    </ul>

                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                        </div>
                    @endforeach

                    <!-- /.col-md-6 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{$name}} Varyant Listesi</h3>
                                <div  class="card-tools">
                                    <button class="btn btn-success btn-md" onclick="bulkpriceupdate({{$pid}})">Toplu Fiyat Oluştur</button> &nbsp; &nbsp;
                                    <a style="display: none" href="{{route('Product.Export',$pid)}}">Excel Şablonu İndir</a> &nbsp; &nbsp;
                                    <a style="display: none" data-toggle="modal" data-target="#uploadModal" href="{{route('Product.import',$pid)}}">Excel Yükle</a>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                                <input type="hidden" name="productid" value="{{$pid}}">
                            <div class="card-body table-responsive">
                                <table class="table table-striped table- table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width:5px">#</th>
                                        <th>Resim</th>
                                        <th>Sku</th>
                                        <th>Ürün Adı</th>
                                        <th>Miktar</th>
                                        <th>Alış Fiyat</th>
                                        <th>Satış Fiyatı</th>
                                        <th>Ağırlık</th>
                                        <th>Uzunluk</th>
                                        <th>Genişlik</th>
                                        <th>Yükseklik</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($variants as $rs)
                                        <tr>
                                            <td style="width:5px"><a  data-id="{{$rs->id}}" data-toggle="modal" onclick="showimagemodal({{$rs->id}})"><i class="fas fa-pen fa-plus"></i> </a>
                                            </td>
                                            <td style="width:100px"><img src="{{$rs->image}}" width="100" alt=""></td>
                                            <td style="width:10px">{{$rs->sku}}</td>
                                            <td>{{$rs->name}}</td>
                                            <td style="width: auto !important;"><input style="width:54px" type="text" onchange="update({{$rs->id}},'quantity',this.value)" name="quantity" value="{{$rs->quantity}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:100px" type="text" onchange="update({{$rs->id}},'purchase_price',this.value)" name="purchase_price" value="{{$rs->purchase_price}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:100px" type="text" onchange="update({{$rs->id}},'price',this.value)" name="price" value="{{$rs->price}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:54px" type="text" onchange="update({{$rs->id}},'weight',this.value)" name="weight" value="{{$rs->weight}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:54px" type="text" onchange="update({{$rs->id}},'length',this.value)" name="length" value="{{$rs->length}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:54px" type="text" onchange="update({{$rs->id}},'width',this.value)" name="width" value="{{$rs->width}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                            <td><input style="width:54px" type="text" onchange="update({{$rs->id}},'height',this.value)" name="height" value="{{$rs->height}}" data-id="{{$rs->id}}" id="p{{$rs->id}}"></td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->



                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>


    <div class="modal fade" id="imageUploadModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Resim Yükleme</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' action='' enctype="multipart/form-data">
                        Dosya Seç : <input type='file' name='file' id='imagefile' class='form-control' ><br>
                        <input type='button' class='btn btn-info' value='Yükle' id='btn_imageupload'>
                        <input type='hidden' id="modalpvid">
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section("js")
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        function optionedit(pid)
        {



            $.ajax({
                data: {
                    id:pid,
                },
                url: '{{route("ProductOptions.get")}}',
                type: "POST",
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: '<h3>Seçenek Adı</h3>',
                        input: 'text',
                        inputValue: response.name,
                        showCancelButton: !0,
                        confirmButtonText: "Güncelle!",
                        cancelButtonText: "İptal!",
                        reverseButtons: !0
                    }).then(function (e) {
                        if (e.isConfirmed === true) {

                            $.ajax({
                                type: 'POST',
                                url: '{{route("ProductOptions.updateoptions")}}',
                                data: {
                                    name: e.value,
                                    id:pid,

                                },
                                dataType: 'JSON',
                                success: function (results) {
                                    if (results.success === true) {
                                        swal.fire("Başarılı!", results.message, "success");
                                        // refresh page after 2 seconds
                                        setTimeout(function(){
                                            location.reload();
                                        },2000);
                                    } else {
                                        swal.fire("Hata!", results.message, "error");
                                    }
                                }
                            });
                        } else {
                            e.dismiss;
                        }
                    }, function (dismiss) {
                        return false;
                    });

                }
            });






        }

        function optionadd(oid)
        {

            let pid =$('#pid').val();
            console.log(pid);
            Swal.fire({
                title: '<h3>Seçenek Adı</h3>',
                text: "Araya virgül(,) koyarak birden fazla seçenek girebilirsiniz",
                input: 'text',
                showCancelButton: !0,
                confirmButtonText: "Ekle!",
                cancelButtonText: "İptal!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.isConfirmed === true) {

                    $.ajax({
                        type: 'POST',
                        url: '{{route("ProductOptions.add")}}',
                        data: {
                            optionsValue: e.value,
                            oid:oid,
                            pid:pid

                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal.fire("Başarılı!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },2000);
                            } else {
                                swal.fire("Hata!", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            });
        }

        function optionvaluedelete(ovid)
        {
            Swal.fire({
                title: 'Eminmisin?',
                text: "Bunu İşlemi Geri Alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, Sil!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/admin/optionvaluedelete')}}/" + ovid,
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal.fire("Başarılı!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },2000);
                            } else {
                                swal.fire("Hata!", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }

        function optiondelete(oid)
        {
            let pid =$("#pid").val();



            Swal.fire({
                title: 'Eminmisin?',
                text: "Seçenek ve Seçeneğe Ait Değerler Silinecektir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, Sil!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'POST',
                        url: '{{route("ProductOptions.optiondelete")}}',
                        data: {

                            oid:oid,
                            pid:pid


                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal.fire("Başarılı!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },2000);
                            } else {
                                swal.fire("Hata!", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }

        $('#btn_upload').click(function() {
            let pid =$('#pid').val();
            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file',files);
            fd.append('id',pid);

            $.ajax({
                url: '{{route("Product.import")}}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                    }else{
                        alert('file not uploaded');
                    }
                }
            });




        });
        $('#btn_imageupload').click(function() {
            let pvid =$('#modalpvid').val();
            var fd = new FormData();
            var files = $('#imagefile')[0].files[0];
            fd.append('file',files);
            fd.append('pvid',pvid);

            $.ajax({
                url: '{{route("Product.variantimageupload")}}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response){

                        $('#imageUploadModal').fadeOut(1000,function(){
                            $('#imageUploadModal').modal('hide');
                            location.reload();
                        });
                    }else{
                        alert('file not uploaded');
                    }
                }
            });




        });


        var spinner = $('#loader');
        function update(id,name,x)
        {


            var data={id:id,name:name,deger:x}

            spinner.show();
            $.ajax({
                data: data,
                url: "{{ route('Product.variantpivot') }}",
                type: "POST",
                dataType: 'json',
                success: function(response) {

                    spinner.hide();

                }
            });
        }


       function showimagemodal(pvid)
       {
           $('#modalpvid').val(pvid);
           $('#imageUploadModal').modal('show');
       }

       function bulkpriceupdate(pid)
       {

           Swal.fire({
               title: '<h3>Fiyat Hesaplama</h3>',
               text: "Kar Marjını Giriniz",
               input: 'text',
               showCancelButton: !0,
               confirmButtonText: "Fiyatları Oluştur!",
               cancelButtonText: "İptal!",
               reverseButtons: !0
           }).then(function (e) {
               if (e.isConfirmed === true) {
                   $.ajax({
                       type: 'POST',
                       url: '{{route("Product.bulkpriceupdate")}}',
                       data: {
                           marj: e.value,
                           pid:pid

                       },
                       dataType: 'JSON',
                       beforeSend: function(){
                           spinner.show();
                       },
                       success: function (results) {
                           console.log(results);
                           if (results.success === true) {

                               // refresh page after 2 seconds
                               setTimeout(function(){
                                   swal.fire("Başarılı!", results.message, "success");

                               },2000);
                               setTimeout(function(){
                                   location.reload();
                               },2000);
                           } else {
                               swal.fire("Hata!", results.message, "error");
                           }
                       },
                       complete:function ()
                       {
                           setTimeout(function(){

                               spinner.hide();
                           },2000);
                       }
                   });
               } else {
                   e.dismiss;
               }
           }, function (dismiss) {
               return false;
           });
       }




    </script>
@endsection

