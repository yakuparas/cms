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
                                <form method="POST" action="{{ route('Slider.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Resim</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input required name="image" type="file" id="title" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Url</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input name="url" type="text" id="title" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Açıklama</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="description" class="summernote">

                                                <div>
                                        <h4>Küçük Başlık</h4>
                                        <h1>Başlık</h1>
                                        <a href="#" class="btn btn-solid" tabindex="0">Devam</a>
                                    </div>

                                            </textarea>

                                        </div>
                                    </div>


                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <input class="btn btn-primary" type="submit" value="Kaydet">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script>
        $(function() {
            $('.summernote').summernote(); });
    </script>
@endsection
