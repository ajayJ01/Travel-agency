<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
Use File;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function __construct(protected AdminService $AdminService)
    {
    }

    public function index(){
        return view('admin.auth.dashboard');
    }
    public function profile(){
        $admin              = Auth::guard('admin')->user();
        $data['profile']    = $admin;
        //prd($data);
        return view('admin.auth.profile',$data);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => ['required'],
        ]);
        try {
            $this->AdminService->updateProfile($request->except('_token'));
            return redirect()->route('admin.profile')->with('success', 'Profile Updated successfully.');
        }
        catch(Exception $e)
        {
            return redirect()->route('admin.profile')->with('error', 'Something went wrong!');
        }
    }

    public function changePassword(){
        $admin = Auth::guard('admin')->user();
        return view('admin.auth.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'confirmed',
                'alpha_num',
                'min:6',
                'max:16',
            ],
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }
        try {
            $this->AdminService->updatePassword($request->except('_token'));
            return redirect()->route('admin.change-password')->with('success', 'Password Updated successfully.');
        }
        catch(Exception $e)
        {
            return redirect(route('admin.addons.index'))->withErrors('Something went wrong!');
            return redirect()->route('admin.change-password')->with('error', 'Something went wrong!');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
