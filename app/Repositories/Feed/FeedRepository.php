<?php

namespace App\Repositories\Feed;

use File;
use Image;
use App\Constants\Constants;
use App\Models\Feed\Feed;
use App\Models\Vendor\Vendor;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class FeedRepository
{
    /**
     * Create Vendor.
     *
     * @param array $request, Array $vendor
     */
    public function createFeed($request)
    {
        try{
            $header_parameter           = Constants::BLANK_ARRAY;
            foreach ($request['header_attribute_id'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['header_attribute_value'][$key];
                $header_parameter[]     = $data;
            }
            $header_parameter           = json_encode($header_parameter);

            $body_parameter             = Constants::BLANK_ARRAY;
            foreach ($request['body_attribute_id'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['body_attribute_value'][$key];
                $body_parameter[]       = $data;
            }
            $body_parameter             = json_encode($body_parameter);

            $data                       = $request;
            $data['header_parameter']   = $header_parameter;
            $data['body_parameter']     = $body_parameter;
            Feed::create($data);
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating feed: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding feed');
             return redirect()->route('admin.feed.show');
        }
    }

    /**
     * Create Feed.
     *
     * @param array $request, Array $vendor
     */
    public function getFeeds()
    {
        try{
            $feed = Feed::orderBy('id', 'DESC')->with('vendorDetails')->paginate(10);
            return $feed;
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while getting attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while getting attribute');
            return redirect()->route('attribute.show');
        }
    }
    /**
     * Get Feed.
     *
     * @param array $request, Array $vendor
     */
    public function getFeedData($id)
    {
        try{
            $feeds = Feed::findOrFail($id);
            if (!is_array($feeds->header_parameter)) {
                $feeds->header_parameter = json_decode($feeds->header_parameter, true);
            }
            if (!is_array($feeds->body_parameter)) {
                $feeds->body_parameter = json_decode($feeds->body_parameter, true);
            }
            return $feeds;
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while getting attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while getting attribute');
            return redirect()->route('attribute.show');
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
            Feed::findOrFail($id)->delete();
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while deleting Vendor: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while deleting Vendor');
            return redirect()->route('vendor.show');
        }
    }

    /**
     * Update Vendor.
     *
     * @param array $request, Array $vendor
     */
    public function updateFeed($request, $id)
    {
        //try{
        prd($request);
            $header_parameter           = Constants::BLANK_ARRAY;
            foreach ($request['header_attribute_id'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['header_attribute_value'][$key];
                $header_parameter[]     = $data;
            }
            $header_parameter           = json_encode($header_parameter);

            $body_parameter             = Constants::BLANK_ARRAY;
            foreach ($request['body_attribute_id'] as $key => $val) {
                $data['key']            = $val;
                $data['value']          = $request['body_attribute_value'][$key];
                $body_parameter[]       = $data;
            }
            $body_parameter             = json_encode($body_parameter);

            $feed                       = Feed::findOrFail($id);
            $data                       = $request;
            $data['header_parameter']   = $header_parameter;
            $data['body_parameter']     = $body_parameter;
            $feed->update($data);
        /* }
        catch(Exception $e)
        {
            Log::error('Error occurred while updating feed: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while updating feed');
             return redirect()->route('admin.feed.show');
        } */
    }
}
