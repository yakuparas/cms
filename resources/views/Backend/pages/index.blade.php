@extends("Backend.layouts")
@section("title","Sayfa İşlemleri")
@section("content")
    <div class="content-wrapper">
    <div class="content pt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('Page.create')}}" class="btn btn-primary">Sayfa Ekle</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                    <tr class="text-center">
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th class="text-center">Sayfa Adı</th>
                                        <th>Url</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($data as $rs)
                                        <tr>
                                            <td>{{ $rs->id }}</td>
                                            <td>{{ $rs->title }}</td>

                                            <td>{{ $rs->slug }}</td>

                                            <td>
                                                <a href="{{ route('Page.edit', $rs->id) }}" class="btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-edit"></i></a>
                                                <a href="#" onclick="deleteConfirmation({{ $rs->id }})"

                                                   class="btn btn-icon btn-sm btn-secondary delete-confirm"><i
                                                            class="fa fa-trash" aria-hidden="true"></i>
                                                </a>



                                            </td>

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
@section("js")
    <script>
        function deleteConfirmation(id) {
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
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/admin/page/delete') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Başarılı!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire("Hata!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endsection