<?php


namespace App\Http\Controllers\Admin\Airline;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAirline()
    {
          
        $airlines = Airline::orderBy('id', 'DESC')->paginate(10);
        return view('admin.airline.index')->with('airlines', $airlines);
    }
    // public function CreateAirline()
    // {
    //     return view('admin.airline.create');
    // }
    
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
           
    //     ]);


       

    //     $data = $request->all();
     
    //     $status = Airline::create($data);

    //     if ($status) {
    //         request()->session()->flash('success', 'Vendor successfully added');
    //     } else {
    //         request()->session()->flash('error', 'Error occurred while adding Vendor');
    //     }

    //     return redirect()->route('vendor.show');
    // }
    // public function AirlineEdit($id)
    // {

    //     $vendors = Airline::findOrFail($id);

   

    //     return view('admin.vendor.edit')->with('vendors', $vendors);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  

    public function AirlineUpdate(Request $request, $id)
    {
       
        $request->validate([
            'name' => 'required',
            'email' => 'required',
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

        $vendor = Airline::findOrFail($id);
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


    public function delete($id)
    {
        $vendors = Airline::find($id);
        if ($vendors) {
            $status = $vendors->delete();
            if ($status) {
                request()->session()->flash('success', 'Vendor successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('vendor.show');
        } else {
            request()->session()->flash('error', 'Vendor not found');
            return redirect()->back();
        }
    }
}
