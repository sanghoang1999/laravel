<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showloginForm()
    {
        return View('backend.login');
    }
    public function login(Request $request) 
    {   $request->remember=='remember' ? $remember=true : $remember=false;
        $count =DB::table('users')->where('email',$request->email)->count();
        if($count >0) {
            if(Auth::attempt(['email' =>$request->email, 'password' =>$request->password],true)) {
                return redirect('admin/home');
            }
            else return back()->withErrors(['password'=>'Mật khẩu không đúng'])->withInput();
        }
        else return back()->withErrors(['email'=>'Email Không tồn tại'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('admin/login');
    }
}
