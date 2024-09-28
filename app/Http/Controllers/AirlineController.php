<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airline;

class AirlineController extends Controller
{
    public function showAirline()
    {
          
        $airlines = Airline::orderBy('id', 'ASC')->paginate(10);
        return view('admin.airline.index')->with('airlines', $airlines);
    }
    public function CreateAirline()
    {
        return view('admin.airline.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
           'code'=> 'required'
        ]);
$status = Airline::create([
    'name'=> $request->name,
    'code'=> $request->code
]);

        if ($status) {
            request()->session()->flash('success', 'Airline successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding Vendor');
        }

        return redirect()->route('airline.show');
    }
    public function AirlineEdit($id)
    {

        $vendors = Airline::findOrFail($id);

   

    
    }
    public function AirlineUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
           'code'=> 'required'
        ]);
        $airline = Airline:: findorfail($id);
$status = $airline->update([
    'name'=> $request->name,
    'code'=> $request->code
]);
       

   

        if ($status) {
            $request->session()->flash('success', 'Airline successfully updated');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('airline.show');
    }


    public function delete($id)
    {
        $delete = Airline::find($id);
        if ($delete) {
            $status = $delete->delete();
            if ($status) {
                request()->session()->flash('success', 'Airline successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('airline.show');
        } else {
            request()->session()->flash('error', 'Airline not found');
            return redirect()->back();
        }
    }
}
