<?php

namespace App\Http\Controllers\admin\apitype;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apitype\Apitype;

class ApitypeController extends Controller
{
    public function ShowApi()
    {  
        $types = Apitype::orderBy('id', 'ASC')->paginate(10);
        return view('admin.apitype.index')->with('types', $types);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
           
        ]);
      $status = Apitype::create([
      'name'=> $request->name,
      
]);
     if ($status) {
            request()->session()->flash('success', ' successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding Vendor');
        }

        return redirect()->route('apitype.show');
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
       
        ]);
        $edit = Apitype:: findorfail($id);
       $status = $edit->update([
      'name'=> $request->name,

       ]);
       if ($status) {
            $request->session()->flash('success', ' successfully updated');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('apitype.show');
    }
    public function delete($id)
    {
        $delete = Apitype::find($id);
        if ($delete) {
            $status = $delete->delete();
            if ($status) {
                request()->session()->flash('success', ' successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('apitype.show');
        } else {
            request()->session()->flash('error', 'not found');
            return redirect()->back();
        }
    }

}
