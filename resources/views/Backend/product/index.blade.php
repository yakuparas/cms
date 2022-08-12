@extends("Backend.layouts")
@section("title","Ürün Yönetimi")
@section("content")
    <div class="content-wrapper pt-2" >
        <section class="content">
            <div class="card">
                <div class="card-header">Ürün Listessi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table-responsive" width="100%">
                        <thead>
                        <tr>
                            <th width="10px">ID</th>
                            <th>Resim</th>
                            <th>Ürün Adı</th>
                            <th>Kodu</th>
                            <th>Barkod</th>
                            <th>Fiyat</th>
                            <th>Varyant</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                    <tbody>

                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        </section>
    </div>

@endsection
@section("js")
    <script>
        function deleteConfirmation(id) {
            Swal.fire({
                title: 'Eminmisin?',
                text: "Ürüne Ait Resimler ve Seçenekler Silinecektir.",
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
                        url: "{{route("Product.delete")}}",
                        data: {
                            _token: CSRF_TOKEN,
                            id:id,
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
        $(function () {
            $("#example2").DataTable({

                lengthChange: false,
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('Product.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                    { data: 'image', name: 'image',
                        render: function( data, type, full, meta ) {
                            return "<img src=\"" + data + "\" height=\"50\"/>";
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'model', name: 'model'},
                    {data: 'sku', name: 'sku'},
                    {data: 'price', name: 'price'},
                    {data: 'isVariable', name: 'isVariable',
                        render:function (data,type,full,meta)
                        {

                            if(data==1)
                            {

                                return "<input disabled='disabled' type='checkbox' checked>";
                            }else
                            {
                                return "<input disabled='disabled' type='checkbox'>";
                            }
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]

            });

        });
    </script>
@endsection
