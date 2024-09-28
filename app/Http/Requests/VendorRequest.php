<?php

namespace App\Http\Requests;

use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => ['required','string'],
            'environment'       => ['required'],
            'email'             => ['required','email'],
            'phone'             => ['required','integer'],
            'code'              => ['required', 'code', Rule::unique('vendors', 'code')->ignore($this->vendor_id)],
            'contact_person'    => ['required','string'],
            'commission'        => ['required'],
        ];
    }
}
