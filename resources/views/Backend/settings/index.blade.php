@extends("Backend.layouts")
@section("title","Site Ayarları")
@section("content")
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <form action="{{route('Setting.update', [ 'id'=> $data->id ])}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Site Ayarları
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('Setting.update', [ 'id'=> $data->id ])}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col-3 col-sm-2">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Genel</a>
                                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Seo</a>
                                    <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Sosyal Medya</a>
                                    <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Email</a>
                                </div>
                            </div>
                            <div class="col-5 col-sm-5">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Mağaza Adı</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="company" value="{{$data->company}}" class="form-control" id="site-title">
                                                <input type="hidden" name="id" value="{{$data->id}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Telefon Numarası</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="phone" value="{{$data->phone}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Mobile</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="mobile" value="{{$data->mobile}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Fax</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="fax" value="{{$data->fax}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Email</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="email" value="{{$data->email}}" class="form-control" id="site-title">
                                            </div>
                                        </div>


                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Logo</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="file" name="logo" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="file" name="favicon" class="form-control" id="site-title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                        <div class="form-group row align-items-center">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Site Title</label>
                                            <div class="col-sm-6 col-md-9">
                                                <textarea class="form-control" name="title" id="site-description"> {{$data->title}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Site Keywords</label>
                                            <div class="col-sm-6 col-md-9">
                                                <textarea class="form-control" name="keywords" id="site-description">{{$data->keywords}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Site Description</label>
                                            <div class="col-sm-6 col-md-9">
                                                <textarea class="form-control" name="description" id="site-description">{{$data->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="form-control-label col-sm-3 mt-3 text-md-right">Analytics Code</label>
                                            <div class="col-sm-6 col-md-9">
                                                <textarea class="form-control" name="analytics">{{$data->analytics}}</textarea>
                                            </div>
                                        </div>                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Facebook</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="facebook" value="{{$data->facebook}}" class="form-control" id="site-title">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">İnstagram</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="instagram" value="{{$data->instagram}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Twitter</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="twitter" value="{{$data->twitter}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Youtube</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="youtube" value="{{$data->youtube}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Linkedin</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="linkedin" value="{{$data->linkedin}}" class="form-control" id="site-title">
                                            </div>
                                        </div>                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Smtp Host</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtpserver" value="{{$data->smtpserver}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Smtp Email</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtpemail" value="{{$data->smtpemail}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Smtp Password</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="password" name="smtppassword" value="{{$data->smtppassword}}" class="form-control" id="site-title">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Smtp Port</label>
                                            <div class="col-sm-6 col-md-9">
                                                <input type="text" name="smtpport" value="{{$data->smtpport}}" class="form-control" id="site-title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>

                    </div>
                    <div class="card-footer">
                        <input type="submit" value="Kaydet" class="btn btn-primary">

                    </div>
                    <!-- /.card -->
                </div>
                </form>
            </div>
        </section>
    </div>
@endsection