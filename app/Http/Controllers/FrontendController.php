<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Middleware\CheckCustomer;
use Auth;
use App\Comment;
use App\Customer;
use Illuminate\Support\Facades\DB;
class FrontendController extends Controller
{
    public function __construct() 
    {
        //  $this->middleware('customer:customer');
    }
    public function index()
    {   
        $featured=Product::where('prod_featured',1)->orderBY('prod_id','desc')->take(8)->get();
        $news=Product::orderBy('prod_id','desc')->take(8)->get();
        return View('frontend.home',compact(['featured','news'])); 
    }
    public function getDetail($id)
    
    { 
        //  $ct_id=Auth::guard('customer')->id();
        //   $carts=DB::table('order_products as op')->join('products as pd','pd.prod_id','=','op.prod_id')->where('op.customer_id',$ct_id)->orderBy('op.created_at','desc')->get();
         $comments=DB::table('customers as ct')->join('comments as cm','cm.ct_id','=','ct.id')->where('cm.prod_id','=',$id)->orderBy('cm.created_at','desc')->get();
        $prod=Product::find($id);
        return View('frontend.details',compact(['prod','comments']));
    }
    public function getProdByCate($id)
    {
        $prods=Product::where('cate_id',$id)->take(8)->get();
        return View('frontend.category',compact('prods'));
    }
    public function storeComment(Request $request,$id_prod) 
    {
        if(Auth::guard('customer')->check()) {
            $id_user=Auth::guard('customer')->id();
            $cm=new Comment();
            $cm->content=$request->cm;
            $cm->ct_id=$id_user;
            $cm->prod_id=$id_prod;
            $cm->save();
            $comments=DB::table('customers as ct')->join('comments as cm','cm.ct_id','=','ct.id')->where('cm.prod_id','=',$id_prod)->where('cm.id','=',$cm->id)->get();
            return response()->json($comments);

        }
        else {
            return response()->json(['error'=>'Chưa đang nhập']);
        }
    }
    public function LoginToComment(Request $request) {
        $count = DB::table('customers')->where('email',$request->email)->count();
        if($count >0) {
            if(Auth::guard('customer')->attempt(['email' =>$request->email, 'password' =>$request->password])) {
                    return response()->json('success');
            }
            else return response()->json(['error'=>'Mật khẩu không đúng']);
        }
        else return  response()->json(['error'=>'Email Không tồn tại']);
    }
    public function search(Request $request)
    {   $result=$request->text;
        $key=$request->text;
        $key=str_replace(' ','%',$key);
        $prods=Product::where('prod_name','like','%'.$key.'%')->get();
        return View('frontend.search',compact(['prods','result']));
    }
}