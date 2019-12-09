<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;
use WindowsAzure\Common\Internal\Validate;
use Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() 
    {
        $this->middleware('admin');
    }
    public function index()
    {    $cates=Category::all();
        return View('backend.category',compact('cates'));
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
    {   if(Category::where('cate_name',$request->name)->count() >0) {
            return response()->json(['error'=>'Tên danh mục đã tồn tại']);
        }
        else {
            $validator=Validator::make($request->all(),
                [
                    'name'=>'bail|required'
                ],
                [
                    'name.required'=>'Nhập danh mục',
                ]
            );
            if($validator->fails()) {
                return  response()->json(['error'=>$validator->errors()->all()]);
            }
            else {
            $cate= new Category();
            $slug=str_slug($request->name);
            $cate->cate_name=$request->name;
            $cate->cate_slug=$slug;
            $cate->save();
            return response($cate);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$cc=DB::table('categories')->where('cate_id',$id)->get();
        $show=Category::find($id);
        return response($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit=Category::find($id);
        return response($edit);
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
        if(Category::where('cate_name',$request->name)->count() >0) {
            return response()->json(['error'=>'Tên danh mục đã tồn tại']);
        }
        else {
            $validator=Validator::make($request->all(),
                [
                    'name'=>'bail|required'
                ],
                [
                    'name.required'=>'Nhập danh mục',
                ]
            );
            if($validator->fails()) {
                return  response()->json(['error'=>$validator->errors()->all()]);
            }
            else {
            $cate=Category::find($id);
            $slug=str_slug($request->name);
            $cate->cate_name=$request->name;
            $cate->cate_slug=$slug;
            $cate->save();
            return response($cate);
            }
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
        $cate=Category::find($id);
        $cate->delete();
        return response($cate);
    }
}
