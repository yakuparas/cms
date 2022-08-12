@extends("Backend.layouts")
@section("title","Ürün Ekle")

@section("content")
    <div class="content-wrapper">
    <section class="content pb-2 pt-2">
        <div class="container-fluid">
            <form method="post" action="{{route("Product.store")}}" enctype="multipart/form-data">
                @csrf
            <div class="row">
             <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ürün Bilgileri</h3>
                    <div class="card-tools">

                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ürün Adı</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Ürün Adı">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category" class="form-control">
                                        @foreach ($catList as $rs )
                                            <option value="{{$rs->id}}">{{\App\Http\Controllers\Backend\CategoryController::getParentsTree($rs,$rs->title)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"> Açıklama</label>
                            <textarea  name="description" id="summernote" class="summernote"></textarea>
                        </div>

                       <div class="row">
                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label class="col-form-label" for="inputSuccess">Kapak Resmi</label>
                                   <input type="file" name="image" class="form-control">
                               </div>
                           </div>
                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label class="col-form-label" for="inputSuccess">Üretici</label>
                                   <select name="brand" id="" class="form-control">
                                       <option value="0">Doppelstabmatte</option>
                                   </select>
                               </div>
                           </div>
                       </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="inputSuccess">Kapak Resmi</label><br>
                                    <input id="isstatus" name="status" class="form-control" data-on-text="Aktif" data-off-text="Pasif" type="checkbox" checked data-toggle="switch">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="inputSuccess">Ürün Tipi</label><br>
                                    <input id="isvariants" name="variants" class="form-control" data-on-text="Varyantlı" data-off-text="Varyantsız" type="checkbox"  data-toggle="switch">

                                </div>
                            </div>
                        </div>







                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-outline card-primary pb-">
                <div class="card-header">
                    <h3 class="card-title">Seo Ayarları</h3>
                    <div class="card-tools">

                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Metal Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input type="text" name="meta_keyword" class="form-control">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="inputSuccess">Meta Description</label>
                        <textarea class="form-control"  name="meta_description" id="summernote" class="summernote"></textarea>

                    </div>


                </div>
                <!-- /.card-body -->
            </div>
        </div>
             <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Fiyat Bilgileri</h3>
                        <div class="card-tools">

                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Ürün Kodu</label>
                                        <input type="text" name="model" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Barkod</label>
                                        <input type="text" name="sku" class="form-control">
                                    </div>

                                </div>
                            </div>
                        <div class=" priceinfo">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Miktar</label>
                                    <input type="number" value="1" name="quantity" class="form-control">                                    </div>
                                </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Asgari Satış</label>
                                    <input type="number" value="1" name="mquantity" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Alış Fiyatı</label>
                                    <input type="text" name="purchase_price" id="purchase_price" class="form-control">                                    </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Etkisi</label>
                                    <select id="price_prefix" onchange="calculate()" name="price_prefix" class="form-control">
                                        <option  value="+">+ Artır</option>
                                        <option value="-">- Azalt</option>
                                        <option selected value="%">% Oran</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kar Marjı</label>
                                    <input type="text" name="purchase_discount" id="purchase_discount" onchange="calculate()" class="form-control">
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Satış Fiyatı</label>
                                    <input type="text" name="price" id="price" class="form-control ">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>İndirimli Satış Fiyatı</label>
                                    <input type="text" name="discount_price" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kdv Oranı</label>
                                    <select name="tax" id="" class="form-control">

                                            <option value="0.08">%8</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Para Birimi</label>
                                    <select name="currency" id="" class="form-control">
                                        <option value="0">Euro</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ağırlık</label>
                                    <input type="text" name="weight" class="form-control">

                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Uzunluk</label>
                                    <input type="text" name="length" class="form-control">

                                </div>

                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Genişlik</label>
                                    <input type="text" name="width" class="form-control">

                                </div>

                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Yükseklik</label>
                                    <input type="text" name="height" class="form-control">

                                </div>

                            </div>
                        </div>
                </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary btn-block" value="Kaydet">

                    </div>
                    <!-- /.card-body -->
                </div>




            </div>
            </div>
            </form>
    </div>
    </section>
    </div>
@endsection

@section("js")
    <script>
            $(function() {
                $('#summernote').summernote();

                $("#isstatus").bootstrapSwitch();
                $("#isvariants").bootstrapSwitch({
                    'onSwitchChange': function(event, state){
                        if (state)
                        {
                            $(".priceinfo").hide();
                        }
                        else
                        {
                            $(".priceinfo").show();
                        }
                    }
                });


            });

            function calculate()
            {
                let purchase_price= parseFloat($('#purchase_price').val());
                let price_prefix= $('#price_prefix').val();
                let purchase_discount= parseFloat($('#purchase_discount').val());

                let price=0;
                if (purchase_price)
                {

                    if (price_prefix=="+")
                    {
                        price=purchase_price+purchase_discount;
                    }
                    else if (price_prefix=="-")
                    {
                        price=purchase_price-purchase_discount;
                    }
                    else
                    {
                        price=purchase_price+((purchase_price*purchase_discount)/100)
                    }

                    document.getElementById('price').value = price;
                }
                else
                {
                    document.getElementById('purchase_discount').value = "";

                    alert('Lütfen Alış Fiyatını Giriniz');
                }

            }
    </script>
@endsection

