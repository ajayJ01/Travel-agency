<?php


namespace App\Http\Controllers\Admin\Feed;

use App\Http\Controllers\Controller;
use App\Models\Attribute\Attribute;
use App\Models\Vendor\Vendor;
use App\Repositories\Feed\FeedRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class FeedController extends Controller
{
    public function __construct(protected FeedRepository $feedRepository)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data['feeds'] = $this->feedRepository->getFeeds();
        return view('admin.feed.index',$data);
    }
    public function create()
    {
        $data['vendors'] = Vendor::select('id','name')->where(['status'=>'1'])->get();
        $data['attributes'] = Attribute::select('id','name')->where(['status'=>'1'])->get();
        return view('admin.feed.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id'         => 'required|integer',
            'name'              => 'required|string',
            'function_name'     => 'required|string',
            'type'              => ['required', 'string', 'regex:/^[A-Z]+$/'],
        ]);
        try{
            $this->feedRepository->createFeed($request->except('_token'));
            request()->session()->flash('success', 'Feed successfully added');
            return redirect()->route('admin.feed.show');
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating feed: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding feed');
            return redirect()->route('admin.feed.show');
        }
    }
    public function edit($id)
    {
        $data['feeds'] = $this->feedRepository->getFeedData($id);
        $data['vendors'] = Vendor::select('id','name')->where(['status'=>'1'])->get();
        $data['attributes'] = Attribute::select('id','name')->where(['status'=>'1'])->get();
        //prd($data['feeds']);
        return view('admin.feed.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'vendor_id'         => 'required|integer',
            'name'              => 'required|string',
            'function_name'     => 'required|string',
            'type'              => ['required', 'string', 'regex:/^[A-Z]+$/'],
        ]);
        //try{
            $this->feedRepository->updateFeed($request->except('_token'),$id);
            request()->session()->flash('success', 'Feed successfully updated');
            return redirect()->route('admin.feed.show');
        /* }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating feed: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while updating feed');
            return redirect()->route('admin.feed.show');
        } */
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
            $this->feedRepository->deleteVendor($id);
            request()->session()->flash('success', 'Vendor successfully deleted');
            return redirect()->route('vendor.show');
        } catch (Exception $e) {
            request()->session()->flash('error', 'Error, Please try again');
            return redirect()->route('vendor.show');
        }
    }
}
