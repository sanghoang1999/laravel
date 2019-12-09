<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Middleware\CheckCustomer;
use App\Product;
use App\OrderProduct;
use Illuminate\Support\Facades\DB;
use Mail;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() 
    {
         $this->middleware('customer:customer')->except('index');
    }
    public function index(Request $request)
    {
        if($request->ajax()) {
            if(Auth::guard('customer')->check() ) {
                
                return response()->json('success');
            }
            else {
                return response()->json(['error'=>'Chưa đang nhập']);
            }
        }
    


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $id_ct=Auth::guard('customer')->id();
        $prod=Product::where('prod_id',$request->id)->first();
        $count=OrderProduct::where('prod_id',$request->id)->where('active',0)->where('customer_id',$id_ct)->count();
        if($count==0) {
            $order=new OrderProduct();
            $order->prod_id=$request->id;
            $order->customer_id=$id_ct;
            $order->price=$prod->prod_price;
            $order->quanity=1;
            $order->save();
        }
        else {
            $order=OrderProduct::where('prod_id',$request->id)->where('active',0)->where('customer_id',$id_ct)->first();
            $order->prod_id=$request->id;
            $order->customer_id=$id_ct;
            $order->price=$prod->prod_price;
            $order->quanity=$order->quanity+1  ;
            $order->save();
        }
        $data['cart']=DB::table('order_products as op')
        ->join('products as pd','pd.prod_id','=','op.prod_id')
        ->where('pd.prod_id',$request->id)->where('op.customer_id',$id_ct)->where('op.active',0)->select('pd.prod_img','pd.prod_name','pd.prod_price','op.id','op.quanity')->get();
        $data['count']=OrderProduct::where('customer_id',$id_ct)->where('active',0)->sum('quanity');
        if($request->ajax()) {
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prod=Product::find($id);
        return response()->json($prod->prod_name);
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
        $id_ct=Auth::guard('customer')->id();
        $order=OrderProduct::find($id);
        $order->quanity=$request->quanity;
        $order->save();
        
        $data['totalMoney']=DB::table('order_products as op')->where('op.customer_id',$id_ct)->where('op.active',0)->sum(DB::raw('(price*quanity)'));
        $data['money']=$order->quanity * $order->price;

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   $id_ct=Auth::guard('customer')->id();
        $data['count']=OrderProduct::where('customer_id',$id_ct)->where('active',0)->sum('quanity');
        $cart=OrderProduct::find($id);
        $cart->delete();
        return response()->json($data);
    }
    public function detail()
    {   $id_ct=Auth::guard('customer')->id();
        $data['listCarts']=DB::table('order_products as op')
        ->join('products as pd','pd.prod_id','=','op.prod_id')->where('op.customer_id',$id_ct)->where('op.active',0)->orderBy('op.updated_at','desc')->get();
        $data['totalMoney']=DB::table('order_products as op')->where('op.customer_id',$id_ct)->where('op.active',0)->sum(DB::raw('(price*quanity)'));
        //dd($data['totalMoney']);
        return View('frontend.cart',$data);
    }
    public function Mail(Request $request)
    {   $id_ct=Auth::guard('customer')->id();
        $data['info']= $request->all();
        $email=$request->email;
        $data['listCarts']=  $data['listCarts']=DB::table('order_products as op')
        ->join('products as pd','pd.prod_id','=','op.prod_id')->where('op.customer_id',$id_ct)->where('op.active',0)->orderBy('op.updated_at','desc')->get();
        $data['totalMoney']=DB::table('order_products as op')->where('op.customer_id',$id_ct)->where('op.active',0)->sum(DB::raw('(price*quanity)'));
        Mail::send('frontend.email', $data, function ($message) use($email) {
            $message->from('hoangvansang846@gmail.com', 'Sang Hoàng');
            $message->to($email, $email);
            $message->cc('sang.hoang.1999@hcmut.edu.vn', 'Sang Hoàng');
            $message->subject('Xác nhận đơn hàng từ Vietproshop');
        });
        $carts = OrderProduct::where('active',0)->get();
        foreach ($carts as $cart) {
            $cart->active=1;
            $cart->save();
        }
        return redirect('complete');
    }
    public function complete()
    {
        return View('frontend.complete');
    }
}
