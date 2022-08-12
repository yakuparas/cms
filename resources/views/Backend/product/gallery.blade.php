@extends("Backend.layouts")
@section("title","Ürün Resim Galerisi")
@section("content")
    <div class="content-wrapper pt-2">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Ürün Resim Galerisi</h3>
                            </div>
                            <div class="card-body">


                                <form id="dropzoneForm" class="dropzone" action="{{ route('dropzone.upload') }}">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$id}}">
                                </form>
                                <div class="card-footer">

                                    <button type="button" class="btn btn-info" id="submit-all">Resimleri Yükle</button>
                                </div>

                            </div>

                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="gallery gallery-md" id="uploaded_image">
                                            <div class="gallery-item" data-image="/backend/assets/img/news/img03.jpg" data-title="Image 1" href="/backend/assets/img/news/img03.jpg" title="Image 1" style="background-image: url(&quot;/backend/assets/img/news/img03.jpg&quot;);"></div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section("js")
    <script>
        Dropzone.options.dropzoneForm = {
            autoProcessQueue : false,
            acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
            parallelUploads: 10,
            dictDefaultMessage: "Resimleri Seçin veya Sürükleyin.<br>Aynı anda 10  adet resim yükleyebilirsiniz.",

            init:function(){
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this;

                submitButton.addEventListener('click', function(){
                    myDropzone.processQueue();
                });

                this.on("complete", function(){
                    if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                    {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    load_images();
                });

            }

        };

        load_images();

        function load_images()
        {
            var id = $("#id").val();
            var url = "{{ route('dropzone.fetch', ":id") }}";
            url = url.replace(':id', id);
            console.log(url);

            $.ajax({
                url:url,
                success:function(data)
                {
                    $('#uploaded_image').html(data);
                }
            })
        }

        function  deletex(xid)
        {

            $.ajax({
                url:"{{ route('dropzone.delete') }}",
                data:{id : xid},
                success:function(data){
                    load_images();
                }
            })
        }



    </script>
    </script>
@endsection