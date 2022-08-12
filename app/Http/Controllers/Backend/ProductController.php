<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductOptions;
use App\Models\ProductOptionsValues;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;



class ProductController extends Controller
{

    public function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }


        $tmp = $this->combinations($arrays, $i + 1);
        $result = array();

        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }
        return $result;
    }


    function array_cartesian_product($arrays)
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array)
            $size = $size * sizeof($array);
        for ($i = 0; $i < $size; $i ++)
        {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j ++)
                array_push($result[$i], current($arrays[$j]));
            for ($j = ($sizeIn -1); $j >= 0; $j --)
            {
                if (next($arrays[$j]))
                    break;
                elseif (isset ($arrays[$j]))
                    reset($arrays[$j]);
            }
        }
        return $result;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Product::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                   if($row->isVariable==1)
                   {
                       $actionBtn = '<div class="btn-group">
                  <a href=/admin/product/edit/'.$row->id.' class="btn btn-default btn-sm">
                    <i class="far fa-edit"></i>
                  </a>
                <a href="#" onclick="deleteConfirmation('.$row->id.')"
                                                            data-id="'.$row->id.'}"

                                                            class="btn btn-default btn-sm delete-confirm"><i title="Sil"
                                                                class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                  <a href=/admin/product/gallery/'.$row->id.' class="btn btn-default btn-sm">
                    <i class="fas fa-images"></i>
                  </a>
                  <a href=/admin/product/variants/'.$row->id.' class="btn btn-default btn-sm">
                    <i class="fas fa-bezier-curve"></i>
                  </a>
                </div>';
                   }
                   else
                   {
                       $actionBtn = '<div class="btn-group">
                  <a href=/admin/product/edit/'.$row->id.' class="btn btn-default btn-sm">
                    <i class="far fa-edit"></i>
                  </a>
                <a href="#" onclick="deleteConfirmation('.$row->id.')"
                                                            data-id="'.$row->id.'}"

                                                            class="btn btn-default btn-sm delete-confirm"><i title="Sil"
                                                                class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                  <a href=/admin/product/gallery/'.$row->id.' class="btn btn-default btn-sm">
                    <i class="fas fa-images"></i>
                  </a>
                  <a href="#" disabled="" class="btn btn-default btn-sm">
                    <i class="fas fa-bezier-curve" disabled=""></i>
                  </a>
                </div>';
                   }

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("Backend.product.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catList=Category::with('children')->get();


        $options=ProductOptions::where("productID",1)->with('optionsValues')->get();

        return view("Backend.product.add",['catList'=>$catList,'options'=>$options]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data=new Product();
        $data->brandID=$request->brand;
        $data->categoryID=$request->category;
        $data->taxID=$request->tax;
        $data->currencyID=$request->currency;
        $data->model=$request->model;
        $data->sku=$request->sku;
        $data->name=$request->name;
        $data->description=$request->description;
        $data->image=$request->image;
        $data->meta_title=$request->meta_title;
        $data->meta_description=$request->meta_description;
        $data->meta_keyword=$request->meta_keyword;
        if($request->hasFile('image'))
        {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
            );

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/product'), $imageName);
            $path="/images/product/".$imageName;

        }
        else
        {
            $path="/placeholder.jpg";

        }
        $data->image=$path;

        if (isset($request->variants))
        {
            $data->isVariable=1;

        }
        else
        {
            $data->isVariable=0;
            $data->quantity=$request->quantity;
            $data->price=$request->price;
            $data->discount_price=$request->discount_price;
            $data->purchase_price=$request->purchase_price;
            $data->weight=$request->weight;
            $data->length=$request->length;
            $data->width=$request->width;
            $data->height=$request->height;
        }
        if ($data->save()) {

            return redirect()->route('Product.index')->with('success','ürün Başarıyla Eklendi.');
        }
        else
        {
            return redirect()->route('Product.index')->with('error','Ürün Eklenirken Hata Oluştu.');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Product::find($id);
        $catList=Category::with('children')->get();
        return view('Backend.product.edit',['catList'=>$catList,'data'=>$data]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data=Product::find($id);
        $oldresim=$data->image;
        $data->brandID=$request->brand;
        $data->categoryID=$request->category;
        $data->taxID=$request->tax;
        $data->currencyID=$request->currency;
        $data->model=$request->model;
        $data->sku=$request->sku;
        $data->name=$request->name;
        $data->description=$request->description;
        $data->image=$request->image;
        $data->meta_title=$request->meta_title;
        $data->meta_description=$request->meta_description;
        $data->meta_keyword=$request->meta_keyword;
        if($request->hasFile('image'))
        {

            $validatedData = $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
            );

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/product'), $imageName);
            $path="/images/product/".$imageName;
            $data->image=$path;

        }
        else
        {
            $data->image=$oldresim;
        }



        if (isset($request->variants))
        {
            $data->isVariable=1;

        }
        else
        {
            $data->isVariable=0;
            $data->quantity=$request->quantity;
            $data->price=$request->price;
            $data->discount_price=$request->discount_price;
            $data->purchase_price=$request->purchase_price;
            $data->weight=$request->weight;
            $data->length=$request->length;
            $data->width=$request->width;
            $data->height=$request->height;
        }
        if ($data->save()) {

            return redirect()->route('Product.index')->with('success','ürün Başarıyla Eklendi.');
        }
        else
        {
            return redirect()->route('Product.index')->with('error','Ürün Eklenirken Hata Oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;


        $image = ProductGallery::where('pid',$id)->get();
        foreach ($image as $del)
        {

            File::delete(public_path($del->image));
        }

        ProductGallery::where('pid',$id)->delete();
        ProductOptions::where('productID',$id)->delete();
        ProductOptionsValues::where('productID',$id)->delete();
        ProductVariants::where('productID',$id)->delete();
        $product = Product::find($id);
        $path=$product->image;
        $delete=Product::destroy($id);

        if ($delete == 1) {

            File::delete(public_path($path));

            $success = true;
            $message = "ürün Başarıyla Silindi";
        } else {
            $success = true;
            $message = "Ürün Bulunamadı";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
    public function addoptions(Request $request)
    {

        if (isset($request->oid))
        {
            $values=explode(",",$request->optionsValue);

            foreach ($values as $v)
            {
                $optionsvalues=new ProductOptionsValues();
                $optionsvalues->optionsID=$request->oid;
                $optionsvalues->productID=$request->pid;
                $optionsvalues->name=$v;
                $optionsvalues->save();
            }
            return [
                'success' => true,
                'message' => 'Seçenek Eklendi.',
            ];
        }
        else
        {
            $options=new ProductOptions();
            $options->productID=$request->pid;
            $options->name=$request->optionsName;
            if ($options->save())
            {
                $values=explode(",",$request->optionsValue);

                foreach ($values as $v)
                {
                    $optionsvalues=new ProductOptionsValues();
                    $optionsvalues->optionsID=$options->id;
                    $optionsvalues->productID=$request->pid;
                    $optionsvalues->name=$v;
                    $optionsvalues->save();
                }

            }
        }

        return redirect()->back();
    }

    public function getoptions(Request $request)
    {
        Log::info($request->id);

        $options  = ProductOptions::where('id',$request->id)->first();

        return response()->json($options);
    }

    public function updateoptions(Request $request)
    {
        Log::info($request->all());

        $opt=ProductOptions::find($request->id);
        $opt->name=$request->name;
        $opt->save();
        return [
            'success' => true,
            'message' => 'Seçenek Güncellendi.',
        ];
    }

    public function optionvaluedelete($id)
    {
        $is_delete = ProductOptionsValues::where('id', $id)->delete();

        return [
            'success' => $is_delete == 1,
            'message' => ($is_delete == 1) ? "Seçenek Başarıyla Silindi" : "Seçenek Bulunamadı",
        ];
    }

    public function optiondelete(Request $request)
    {
        $deloptionvalues= ProductOptionsValues::where('optionsID', $request->oid)->where('productID',$request->pid)->delete();
        if ($deloptionvalues)
        {
            $is_delete= ProductOptions::where('id',$request->oid)->delete();
        }

        return [
            'success' => $is_delete == 1,
            'message' => ($is_delete == 1) ? "Seçenek Başarıyla Silindi" : "Seçenek Bulunamadı",
        ];

    }


    public function combination(Request $request)
    {

        $pid=$request->prid;
        $varmi=ProductVariants::where('productID', $pid)->get();
        if (count($varmi)>0)
            ProductVariants::where('productID',$pid)->delete();

        $pname=$request->name;
        $options=ProductOptions::where("productID",$pid)->with('optionsValues')->get();
        $varyant=array();
        for ($i=0;$i<count($options);$i++)
        {
            $a=array();
            $uniqid=array();
            for ($j=0;$j<count($options[$i]["optionsValues"]);$j++)
            {
                $x=$options[$i]["optionsValues"][$j]["name"];
                array_push($a,$x);
            }
            $varyant[]=$a;
        }

        $sonuc=$this->array_cartesian_product($varyant);
        $uniqid=$pid.substr($pname,0,1);
        for ($i=0;$i<count($sonuc);$i++)
        {
            $uniqid=$pid.substr($pname,0,1);
            foreach ($sonuc[$i] as $r)
            {

               $uniqid.=substr($r,0,1);

            }
            $uniqid.='-'.$i;
            $productvariants=new ProductVariants();
            $productvariants->productID=$pid;
            $productvariants->uniqID=$uniqid;
            $productvariants->sku=$uniqid;
            $productvariants->name=$pname." / ".implode("-",$sonuc[$i]);
            $productvariants->save();
        }

        return redirect()->back();

    }

    public function gallery($id)
    {
        return view('Backend.product.gallery',['id'=>$id]);

    }
    function upload(Request $request)
    {

        $image = $request->file('file');
        $id=$request->id;
        $imageName = 'i'.Str::random(6). '.' . $image->extension();
        if($image->move(public_path("images/product/$id"), $imageName));
        {
            $path="/images/product/".$id.'/'.$imageName;
            $data=new ProductGallery();
            $data->pid=$id;
            $data->image=$path;
            $data->save();
            return response()->json(['success' => $imageName]);
        }

    }


    function fetch($id)
    {



        $images=ProductGallery::where('pid',$id)->get();
        $output = '<div class="row">';
        foreach($images as $image)
        {
            $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="'.asset( $image['image']).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                <input type="hidden" name="rid" id="rid" value="'.$image['id'].'">
                <button type="button" class="btn btn-link remove_image" onclick="deletex('.$image['id'].')"><i title="Sil"
                                                                class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
      ';
        }
        $output .= '</div>';
        echo $output;
    }

    function delete(Request $request)
    {
        if($request->get('id'))
        {
            $img=ProductGallery::find($request->get('id'));
            File::delete(public_path($img->image));
            ProductGallery::destroy($request->get('id'));

        }
    }

    public function variants($id)
    {



        $options=ProductOptions::where('productID',$id)->get();
        $name=Product::find($id);



        $variants=ProductVariants::where('productID',$id)->get();



        return view("Backend.product.variantadd",['options'=>$options,'pid'=>$id,'name'=>$name->name,'variants'=>$variants,'slug'=>$name->slug]);
    }

    public function exportproduct($id)
    {
        $variants=ProductVariants::where('productID',$id)->get();

        return (new FastExcel($variants))->download('file.xlsx');



    }

    public function importproduct(Request $request)
    {


/*
        $path="";
        if($request->hasFile('file'))
        {

            $ename = time().'.'.$request->file->extension();
            $request->file->move(public_path('excell'), $ename);
            $path="/excell/".$ename;

        }
        Log::info($path);*/
       $collection = (new FastExcel)->import('1658930603.xlsx');

        Log::info($collection);


    }


    public function variantpivot(Request $request)
    {
        $id=$request->id;
        $name=$request->name;
        $deger=$request->deger;
        $pvariants=ProductVariants::where('id',$id)->update(["{$name}" => "{$deger}"]);;
        if ($pvariants)
        {
            echo true;
        }
        else{
            echo false;
        }

    }


    public function variantimageupload(Request $request)
    {
        Log::info($request->all());



        $pvariants=ProductVariants::find($request->pvid);
        if($request->hasFile('file'))
        {



            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images/product'), $imageName);
            $path="/images/product/".$imageName;
            $pvariants->image=$path;

        }
        if ($pvariants->save())
        {
            echo true;
        } else
        {
            echo false;
        }

    }


    public function bulkpriceupdate(Request $request)
    {
             $marj=$request->marj;
            $bulkprice=ProductVariants::where('productID',$request->pid)->get();

            foreach ($bulkprice as $rs)
            {
                $pricex=(($rs->purchase_price*$marj)/100)+$rs->purchase_price;
                $a= DB::table('product_variants')->where('id', $rs->id)->update(array('price' => $pricex));
                Log::info($a);

            }

        $success = true;
        $message = "Fiyatlar Oluşturulmuştur";
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);


    }


















}
