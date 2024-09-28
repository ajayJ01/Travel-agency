<?php

namespace App\Repositories\Attribute;

use File;
use Image;
use App\Constants\Constants;
use App\Models\Attribute\Attribute;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AttributeRepository
{
    /**
     * Create Attribute.
     *
     * @param array $request, Array $vendor
     */
    public function getAttributes()
    {
        try{
            $attribute = Attribute::orderBy('id', 'DESC')->paginate(10);
            return $attribute;
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while getting attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while getting attribute');
            return redirect()->route('attribute.show');
        }
    }
    /**
     * Create Attribute.
     *
     * @param array $request, Array $vendor
     */
    public function getAttributeDetails($id)
    {
        try{
            $attribute = Attribute::findOrFail($id);
            return $attribute;
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while getting attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while getting attribute');
            return redirect()->route('attribute.show');
        }
    }

    /**
     * Create Attribute.
     *
     * @param array $request, Array $vendor
     */
    public function createAttribute($request)
    {
        try{
            $data               = $request;
            $data['slug']       = Str::slug($request['name']);
            $data['status']       = Str::slug($request['status']);
            Attribute::create($data);
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding attribute');
            return redirect()->route('attribute.show');
        }
    }

    /**
     * Create Vendor.
     *
     * @param array $request, Array $vendor
     */
    public function updateAttribute($request, $id)
    {
        try{
            $attribute          = Attribute::findOrFail($id);
            $data               = $request;
            $data['slug']       = Str::slug($request['name']);
            $data['status']     = Str::slug($request['status']);

            $status             = $attribute->update($data);
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding attribute');
            return redirect()->route('attribute.show');
        }
    }
    /**
     * Delete Vendor.
     *
     * @param int $id
     */
    public function deleteAttribute($id)
    {
        try{
            Attribute::findOrFail($id)->delete();
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while deleting attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while deleting attribute');
            return redirect()->route('attribute.show');
        }
    }
}
