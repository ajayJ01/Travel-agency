<?php

namespace App\Http\Controllers\admin\setting;

use App\Http\Controllers\Controller;
use App\Http\Services\GeneralSettingService;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GeneralSettingController extends Controller
{

    public function __construct(protected GeneralSettingService $generalSetting)
    {
    }
    public function index()
    {
        $data['setting'] = GeneralSetting::first();
        //prd($data);
        $data['email_config'] = json_decode($data['setting']->email_config, true) ?? [];
        if (!is_array($data['email_config'])) {
            $data['email_config'] = [];
        }
        return view('admin.setting.setting', $data);
    }



    public function create(Request $request)
{
    $request->validate([
        'site_name'  => 'required',
        'email' => 'required',
        'phone' => 'required',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'favicon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'required',
        'footer' => 'required',
        'descreption' => 'required',
        'currency_name' => 'required',
        'currency_code' => 'required',
        'support_phone' => 'required',
        'service_charge' => 'required',
        'gst_applied' => 'required'
    ]);

    $generalSetting = GeneralSetting::first();
    $imagePath = null;
    $faviconimage = null;

    if ($request->hasFile('logo')) {
        $imageName = time() . '.' . $request->logo->extension();
        $request->logo->move(public_path('setting/logo'), $imageName);
        $imagePath = 'setting/logo/' . $imageName;
    }

    if ($request->hasFile('favicon')) {
        $imageName = time() . '.' . $request->favicon->extension();
        $request->favicon->move(public_path('setting/favicon'), $imageName);
        $faviconimage = 'setting/favicon/' . $imageName;
    }

    $EmailConfiguration = [];
    if ($request->has('email_type') && $request->has('email_value')) {
        foreach ($request->email_type as $key => $type) {
            if (isset($type) && isset($request->email_value[$key])) {
                $EmailConfiguration[$type] = $request->email_value[$key];
            }
        }
    }

    $data = $request->except(['email_type', 'email_value']);
    $data['email_config'] = json_encode($EmailConfiguration);
    $data['logo'] = $imagePath;
    $data['favicon'] = $faviconimage;
// dd($data);
    $status = $generalSetting->update($data);

    if ($status) {
        $request->session()->flash('success', 'Successfully updated');
    } else {
        $request->session()->flash('error', 'Error occurred while updating settings');
    }

    return redirect()->route('admin.setting.index');
}

    
}


