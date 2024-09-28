<?php


namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Models\Vendor\Vendor;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Vendor\VendorRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function __construct(protected AttributeRepository $attributeRepository)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $attributes = $this->attributeRepository->getAttributes();
        return view('admin.attribute.index')->with('attributes', $attributes);
    }
    public function create()
    {
        return view('admin.attribute.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:attribute,name',
        ]);
        try{
            $this->attributeRepository->createAttribute($request->except('_token'));
            request()->session()->flash('success', 'Attribute successfully added');
            return redirect()->route('attribute.show');
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while creating attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while adding attribute');
            return redirect()->route('attribute.show');
        }
    }
    public function edit($id)
    {
        $attribute = $this->attributeRepository->getAttributeDetails($id);
        return view('admin.attribute.edit')->with('attribute', $attribute);
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
            'name' => ['required','string',Rule::unique('attribute')->ignore($id),
            ],
        ]);

        try{
            $this->attributeRepository->updateAttribute($request->except('_token'),$id);
            request()->session()->flash('success', 'Attribute successfully added');
            return redirect()->route('attribute.show');
        }
        catch(Exception $e)
        {
            Log::error('Error occurred while update attribute: ' . $e->getMessage());
            request()->session()->flash('error', 'Error occurred while update attribute');
            return redirect()->route('attribute.show');
        }

        return redirect()->route('attribute.show');
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
            $this->attributeRepository->deleteAttribute($id);
            request()->session()->flash('success', 'Attribute successfully deleted');
            return redirect()->route('attribute.show');
        } catch (Exception $e) {
            request()->session()->flash('error', 'Error, Please try again');
            return redirect()->route('attribute.show');
        }
    }
}
