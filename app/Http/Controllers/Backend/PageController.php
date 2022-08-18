<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Page::get();
        return view('Backend.pages.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.pages.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=new Page();
        $data->title=$request->title;
        $data->description=$request->description;
        if ($data->save()) {

            return redirect()->route('Page.list')->with('success','Başarıyla Eklendi.');
        }
        else
        {
            return redirect()->route('Page.list')->with('error','Hata Oluştu.');
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
        $data=Page::find($id);

        return view('Backend.pages.edit',['data'=>$data]);
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
        $data=Page::find($id);
        $data->title=$request->title;
        $data->slug=$request->slug;
        $data->description=$request->description;
        if ($data->save()) {


            return redirect()->route('Page.list')->with('success','Başarıyla Güncellendi.');
        }
        else
        {
            return redirect()->route('Page.list')->with('error','Güncellenirken Hata Oluştu.');
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
        $delete=Page::destroy($id);

        // check data deleted or not
        if ($delete == 1) {


            $success = true;
            $message = "Sayfa Başarıyla Silindi";
        } else {
            $success = true;
            $message = "Sayfa Bulunamadı";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
