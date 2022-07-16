<?php

namespace App\Http\Requests;

class AddAddressRequest extends CustomRequest
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
            'receiverName' => 'required|string',
            'receiverEmail' => 'required|string',
            'receiverCountryCode' => 'required|integer',
            'receiverPhoneNumber' => 'required|integer',
            'addressLine1' => 'required|string',
            'addressLine2' => 'string|nullable',
            'postcode' => 'required|integer',
            'city' => 'required|string',
            'state' => 'required|string',
            'countryId' => 'required|integer',
            'default' => 'required|boolean',
            'tagId' => 'integer|nullable'
        ];
    }
}
