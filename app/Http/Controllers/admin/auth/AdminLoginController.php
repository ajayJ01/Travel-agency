<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index(){
        return view('admin.auth.login');
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->passes()){
            if(Auth::guard('admin')->attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ],$request->get('remember'))){
                    $admin = Auth::guard('admin')->user();
                    if($admin->role == 1){
                        return redirect()->route('admin.dashboard')->with('Login successfully.');
                    }else{
                        Auth::guard('admin')->logout();
                        return redirect()->route('admin.login')->with('error','You are not authorize to access admin panel, Please contact to admin.');
                    }
            }else{
                return redirect()->route('admin.login')->with('error','Email/Password not correct');
            }
        }else{
            return redirect()->route('admin.login')
            ->withErrors($validator)
            ->WithInput($request->only('email'));
        }
    }
}
