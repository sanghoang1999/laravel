<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Storage;
use Builder;
class ProductController extends Controller
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
    {
        $datas=DB::table('products as prod')->join('categories as cate','prod.cate_id','=','cate.cate_id')->orderBy('prod_id','desc')->get();
        return View('backend.product',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $cates=DB::table('categories')->select('*')->get();
        return View('backend.addproduct',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $validator=Validator::make($request->all(),[
             'img'=>'image',
             'name'=>'unique:products,prod_name',
        ],
        [
            'img.image'=>'File image không hộp lệ',
            'name.unique'=>'Tên sản phẩm đã tồn lại',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else {
            $filename=$request->img->getClientOriginalName();
            $filename=time().'-'.$filename;
            $product= new Product();
            $product->prod_name=$request->name;
            $product->prod_slug=str_slug($request->name);
            $product->prod_price=$request->price;
            $product->prod_img=$filename;
            $product->prod_warranty=$request->warranty;
            $product->prod_accessories =$request->accessories;
            $product->prod_condition=$request->condition;
            $product->prod_promotion=$request->promotion;
            $product->prod_status=$request->status;
            $product->prod_description=$request->description;
            $product->prod_featured=$request->featured;
            $product->cate_id=$request->cate;
            $product->save();
            //$request->file('img')->storeAs('storage', $filename, 'public_resources');
            $request->img->storeAs('storage',$filename);
            //$request->img->move(base_path('public_html/storage'),$filename);
            return back()->with('success','Bạn đã Sửa thành công');
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
        $data=Product::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $prod= Product::find($id);
        $cates=DB::table('categories')->select('*')->get();
        return View('backend.editproduct',compact(['cates','prod']));
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
        $count=DB::table('products')->where('prod_name',$request->prod_name)->where('prod_id','!=',$id)->count();
        if($count >0) {
            return back()->withErrors(['name'=>'Tên sản phẩm đã tồn tại']);
        }
        $validator=Validator::make($request->all(),[
            'img'=>'image',
        ],
        [
            'img.image'=>'File ảnh không hộp lệ',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else {
            $product= Product::find($id);
            $product->prod_name=$request->name;
            $product->prod_slug=str_slug($request->name);
            $product->prod_price=$request->price;
            $product->prod_warranty=$request->warranty;
            $product->prod_accessories =$request->accessories;
            $product->prod_condition=$request->condition;
            $product->prod_promotion=$request->promotion;
            $product->prod_status=$request->status;
            $product->prod_description=$request->description;
            $product->prod_featured=$request->featured;
            $product->cate_id=$request->cate;
            if($request->hasFile('img')) {
                $oldImage=$product->prod_img;
                Storage::delete('public/'.$oldImage);
                $filename=$request->img->getClientOriginalName();
                $filename=time().'-'.$filename;
                $request->img->storeAs('public',$filename);
                $product->prod_img=$filename;
            }
            $product->save();
            return back()->with('success','Bạn đã sửa thành công');
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
        $product=Product::find($id);
        $product->delete();
        $imageName=$product->prod_img;
        Storage::delete('storage/'.$imageName);
        return response($product);
    }
}
