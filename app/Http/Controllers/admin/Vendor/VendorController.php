<?php


namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor\Vendor;
use App\Repositories\Vendor\VendorRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function __construct(protected VendorRepository $vendorRepository)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVendor()
    {

        $vendors = Vendor::orderBy('id', 'DESC')->paginate(10);
        return view('admin.vendor.index')->with('vendors', $vendors);
    }
    public function CreateVendor()
    {
        return view('admin.vendor.create-vendor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'commission'        => 'required',
            'environment'       => 'required',
            'email'             => 'required|email|unique:vendors,email',
            'phone'             => 'required|digits:10',
            'code'              => 'required|unique:vendors,code',
            'contact_person'    => 'required',
        ]);
        try{
            $this->vendorRepository->createVendor($request->except('_token'));
            request()->session()->flash('success', 'Vendor successfully added');
            return redirect()->route('vendor.show');
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating Vendor: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding Vendor');
            return redirect()->route('vendor.show');
        }
    }
    public function vendorEdit($id)
    {
        $vendors = Vendor::findOrFail($id);

        if (!is_array($vendors->sandbox_credentials)) {
            $vendors->sandbox_credentials = json_decode($vendors->sandbox_credentials, true);
        }
        if (!is_array($vendors->live_credentials)) {
            $vendors->live_credentials = json_decode($vendors->live_credentials, true);
        }

        return view('admin.vendor.edit')->with('vendors', $vendors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function vendorUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'commission' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('vendors')->ignore($id),
            ],
            'phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
            'code' => [
                'required',
                Rule::unique('vendors')->ignore($id),
            ],
            'contact_person' => 'required',
        ]);

        $vendor = Vendor::findOrFail($id);
        $sandboxCredentials = [];
        if ($request->has('sandbox_type') && $request->has('sandbox_value')) {
            foreach ($request->sandbox_type as $key => $type) {
                if (isset($type) && isset($request->sandbox_value[$key])) {
                    $sandboxCredentials[] = [
                        'key' => $type,
                        'value' => $request->sandbox_value[$key]
                    ];
                }
            }
        }

        $liveCredentials = [];
        if ($request->has('live_type') && $request->has('live_value')) {
            foreach ($request->live_type as $key => $type) {
                if (isset($type) && isset($request->live_value[$key])) {
                    $liveCredentials[] = [
                        'key' => $type,
                        'value' => $request->live_value[$key]
                    ];
                }
            }
        }

        $data = $request->except(['sandbox_type', 'sandbox_value', 'live_type', 'live_value']);
        $data['sandbox_credentials'] = json_encode($sandboxCredentials);
        $data['live_credentials'] = json_encode($liveCredentials);

        $status = $vendor->update($data);

        if ($status) {
            $request->session()->flash('success', 'Vendor successfully updated');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('vendor.show');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        try {
            $this->vendorRepository->deleteVendor($id);
            request()->session()->flash('success', 'Vendor successfully deleted');
            return redirect()->route('vendor.show');
        } catch (Exception $e) {
            request()->session()->flash('error', 'Error, Please try again');
            return redirect()->route('vendor.show');
        }
    }
}
