<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Slider::get();
        return view('Backend.slider.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.slider.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ],
            );
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/slider'), $imageName);
            $path="/images/slider/".$imageName;

        }


        $data=new Slider();
        $data->url=$request->url;
        $data->description=$request->description;
        $data->image=$path;
        if ($data->save()) {

            return redirect()->route('Slider.list')->with('success','Başarıyla Eklendi.');
        }
        else
        {
            return redirect()->route('Slider.create')->with('error','Hata Oluştu.');
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
        $data=Slider::find($id);

        return view('Backend.slider.edit',['data'=>$data]);
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
        $data=slider::find($id);
        $pathX=$data->image;

        if($request->hasFile('image'))
        {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ],
            );
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/slider'), $imageName);
            $path="/images/slider/".$imageName;
            $data->image=$path;

            File::delete(public_path($pathX));

        }



        $data->url=$request->url;
        $data->description=$request->description;




        if ($data->save()) {


            return redirect()->route('Slider.list')->with('success','Başarıyla Güncellendi.');
        }
        else
        {
            return redirect()->route('Slider.list')->with('error','Güncellenirken Hata Oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Slider::find($id);
        $path=$image->image;
        $delete=slider::destroy($id);

        // check data deleted or not
        if ($delete == 1) {

            File::delete(public_path($path));

            $success = true;
            $message = "Slide Başarıyla Silindi";
        } else {
            $success = true;
            $message = "Slide Bulunamadı";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
