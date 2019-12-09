<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Customer;
use Auth;
use Session;
use redirect;
use Illuminate\Support\Facades\Hash;

class AuthFacebookController extends Controller
{
    public function redirect()
    {    Session::flash('url',$_SERVER['HTTP_REFERER']);
        return Socialite::driver('facebook')->redirect();
    }
    public function callback()
    {
        $info=Socialite::driver('facebook')->user();
        $user=Customer::where('email',$info->email)->first();
        if(!$user) {
            $user = new Customer();
            $user->name=$info->name;
            $user->email=$info->email;
            $user->level=1;
            $user->password=hash::make($info->id);
            $user->save();
        }
        Auth::guard('customer')->login($user);
        return redirect()->to(Session::get('url'));
    }
}
