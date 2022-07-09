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
            'fullName' => 'required|string',
            'gender' => 'required|string',
            'countryCode' => 'required|integer',
            'phoneNumber' => 'required|integer',
            'dob' => 'required|date'
        ];
    }
}
