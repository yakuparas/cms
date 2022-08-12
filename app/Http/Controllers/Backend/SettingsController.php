<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Settings::first();

        if ($data===null)
        {
            $data=new Settings();
            $data->title="Grows E-ticaret Projesi";
            $data->save();
            $data=Settings::first();
        }

        return view('Backend.settings.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        if($request->hasFile('logo'))
        {

            $validatedData = $request->validate([
                'logo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
            );

            $imageName = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $imageName);
            $pathlogo="/images/".$imageName;

        }
        else
        {
            $pathlogo="/logo.jpg";

        }


        if($request->hasFile('favicon'))
        {
            $validatedData = $request->validate([
                'favicon' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
            );

            $imageName = time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('images'), $imageName);
            $pathfav="/images/".$imageName;

        }
        else
        {
            $pathfav="/upload/favicon.png";

        }

        $set=Settings::find($id);
        $set->logo=$pathlogo;
        $set->favicon=$pathfav;
        $set->title=$request->title;
        $set->keywords=$request->keywords;
        $set->description=$request->description;
        $set->company=$request->company;
        $set->phone=$request->phone;
        $set->mobile=$request->mobile;
        $set->fax=$request->fax;
        $set->email=$request->email;
        $set->facebook=$request->facebook;
        $set->instagram=$request->instagram;
        $set->twitter=$request->twitter;
        $set->youtube=$request->youtube;
        $set->linkedin=$request->linkedin;
        $set->analytics=$request->analytics;
        $set->smtpserver=$request->smtpserver;
        $set->smtpemail=$request->smtpemail;
        $set->smtppassword=$request->smtppassword;
        $set->smtpport=$request->smtpport;
        $set->save();


        $data=Settings::first();
        return view('Backend.settings.index',['data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
