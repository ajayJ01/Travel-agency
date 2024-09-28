<?php

namespace App\Repositories\Vendor;

use File;
use Image;
use App\Constants\Constants;
use App\Models\Vendor\Vendor;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class VendorRepository
{
    /**
     * Create Vendor.
     *
     * @param array $request, Array $vendor
     */
    public function createVendor($request)
    {
        try{
            $sandboxDetails     = Constants::BLANK_ARRAY;
            foreach ($request['sandbox_type'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['sandbox_value'][$key];
                $sandboxDetails[]       = $data;
            }
            $sandboxDetails             = json_encode($sandboxDetails);
            $liveDetails                = Constants::BLANK_ARRAY;
            foreach ($request['live_type'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['live_value'][$key];
                $liveDetails[]          = $data;
            }
            $liveDetails                = json_encode($liveDetails);

            $data                       = $request;
            $data['sandbox_credentials']=  $sandboxDetails;
            $data['live_credentials']   =  $liveDetails;
            Vendor::create($data);
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating Vendor: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding Vendor');
            return redirect()->route('vendor.show');
        }
    }

    /**
     * Delete Vendor.
     *
     * @param int $id
     */
    public function deleteVendor($id)
    {
        try{
            Vendor::findOrFail($id)->delete();
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while deleting Vendor: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while deleting Vendor');
            return redirect()->route('vendor.show');
        }
    }
}
