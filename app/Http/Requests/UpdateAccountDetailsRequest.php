<?php

namespace App\Http\Requests;

class UpdateAccountDetailsRequest extends CustomRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'gender' => 'required|string',
            'countryCodeId' => 'required|integer',
            'phoneNo' => 'required|integer',
            'dob' => 'required|date'
        ];
    }
}
