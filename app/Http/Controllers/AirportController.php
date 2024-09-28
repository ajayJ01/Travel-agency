<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;


class AirportController extends Controller
{
    public function showAirport(){
        $airports = Airport::orderBy('id', 'ASC')->paginate(10);
        return view('admin.airport.index')->with('airports', $airports);
    }
    public function createAirport(){


        return view('admin.airport.create');
    }
    public function storeAirport(Request $request){
        $request->validate([
            'name'=>'required',
            'municipality'=>'required',
            'iata_code'=> 'required'
        ]);
       $create = Airport::create([
            'name'=>$request->name,
            'municipality'=>$request->municipality,
            'iata_code'=>$request->iata_code 

        ]);
        if ($create) {
            $request->session()->flash('success', 'Airport successfully created');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('airport.show');
    }
    public function AirportDetail($id){
       $details = Airport::where('id', $id)->get();
        return view('admin.airport.detail',compact('details'));
    }
    public function EditAirport($id){
     $update = Airport::findorfail($id);
     return view('admin.airport.edit',compact('update'));
    }
    public function updateAirport(Request $request , $id){
        $request->validate([
            'name'=>'required',
            'municipality'=>'required',
            'iata_code'=> 'required'
        ]);
        $airport = Airport:: findorfail($id);
     $status =  $airport->update([
            'name'=>$request->name,
            'municipality'=>$request->municipality,
            'iata_code'=>$request->iata_code 

        ]);
        if ($status) {
            $request->session()->flash('success', 'Airport successfully updated');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('airport.show');
    }
    public function deleteAirport(Request $request ,$id){
     $delete = Airport::where('id',$id)->delete();
     if ($delete) {
        $request->session()->flash('success', 'Airport successfully deleted');
    } else {
        $request->session()->flash('error', 'Error occurred, Please try again!');
    }
        return redirect()->route('airport.show');
    }
}
