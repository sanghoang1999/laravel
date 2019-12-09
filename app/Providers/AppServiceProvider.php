<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Category;
use Illuminate\Support\Facades\DB;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        $data['cates']=Category::all();
        view()->share($data);
        view()->composer('*', function ($view) 
            {
               $ct_id=Auth::guard('customer')->id();
               $data['count']=(int)DB::table('order_products')->where('customer_id',$ct_id)->where('active',0)->sum('quanity');
                //dd($data['count']);
                $data['carts']=DB::table('order_products as op')->join('products as pd','pd.prod_id','=','op.prod_id')->where('op.active',0)->where('op.customer_id',$ct_id)->orderBy('op.created_at','desc')->get();
                view()->share($data);    
            });  

    }
}
