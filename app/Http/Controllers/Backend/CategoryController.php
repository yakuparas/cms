<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $appends=['getParentsTree'];

    public static function getParentsTree($category,$title)
    {
        if ($category->parent_id==0) {
            return $title;
        }

        $parent=Category::find($category->parent_id);
        $title=$parent->title.' > '.$title;

        return CategoryController::getParentsTree($parent,$title);
    }

    public static function CatList()
    {
        return $catList = Category::where('parent_id', '=', 0)->with('children')->get();
    }
    public function index()
    {
        $catList=Category::with('children')->get();
        return view('Backend.categories.index',['cat'=>$catList]);
    }

    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
            ],
            );

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $path="/images/".$imageName;

        }
        else
        {
            $path="/upload/kategori.png";

        }

        $cat=new Category();
        $cat->title=$request->title;
        $cat->parent_id=$request->parent;
        $cat->description=$request->description;
        $cat->keywords=$request->keywords;
        $cat->status=$request->status;
        $cat->image=$path;

        if ($cat->save())
        {
            return response()->json([
                'status' => 200,
            ]);
        }

    }

    public function edit($id)
    {
        $data=Category::find($id);


        $catList=Category::with('children')->get();

        return view('Backend.categories.edit',['data'=>$data,'cat'=>$catList]);
    }

    public function update(Request $request)
    {

        try {
            $cat=Category::find($request->catid);
            if($request->hasFile('image'))
            {
                $validatedData = $request->validate([
                    'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
                ],
                );

                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $path="/images/".$imageName;
                $cat->image=$path;

            }


            $cat->title=$request->title;
            $cat->parent_id=$request->parent;
            $cat->description=$request->description;
            $cat->keywords=$request->keywords;
            $cat->status=$request->status;
            if ($cat->save())
            {
                return response()->json([
                    'status' => 200,
                ]);
            }

        } catch (\Exception $e)
        {
            Log::error($e);
        }




    }
}
