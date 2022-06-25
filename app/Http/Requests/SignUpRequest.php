<?php

namespace App\Http\Requests;

class SignUpRequest extends CustomRequest
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
            'name' => 'string|required',
            'countryCodeId' => 'integer|required',
            'phoneNo' => 'integer|required',
            'email' => 'string|required|unique:users,email',
            'password' => 'string|required',
            'dob' => 'date|required',
            'gender' => 'string|required'
        ];
    }
}
