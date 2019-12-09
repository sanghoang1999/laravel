<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use phpDocumentor\Reflection\Types\Null_;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        //$this->middleware('guest:customer')->except('logout');
    }
    public function showloginForm()
    {
        return View('backend.login');
    }
    public function login(Request $request,$true=null) 
    {
        $count =DB::table('customers')->where('email',$request->email)->count();
        dd($count);
        if($count >0) {
            if(Auth::guard('customer')->attempt(['email' =>$request->email, 'password' =>$request->password])) {
                if($true==null) {
                    return redirect('/');
                }
            }
            else return back()->withErrors(['email'=>'Mật khẩu không đúng']);
        }
        else return back()->withErrors(['email'=>'Email Không tồn tại']);
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        return back();
    }
}
