<?php

namespace App\Http\Requests;

class CheckoutRequest extends CustomRequest
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
        $isLoggedIn = auth('sanctum')->check();
        $addressSelected = request()->addressId;

        $addressStringRules = '';
        if ($addressSelected) {
            $addressStringRules = 'prohibited|nullable';
        } else {
            $addressStringRules = 'string|required';
        }

        $addressEmailRules = '';
        if ($addressSelected) {
            $addressEmailRules = 'prohibited|nullable';
        } else {
            $addressEmailRules = 'email|required';
        }

        $addressNumberRules = '';
        if ($addressSelected) {
            $addressNumberRules = 'prohibited|nullable';
        } else {
            $addressNumberRules = 'integer|required';
        }

        return [
            'products' => 'array|required',
            'products.*.id' => 'required|string',
            'products.*.quantity' => 'required|integer',
            'products.*.totalPrice' => 'required|numeric',
            'addressId' => $isLoggedIn ? 'integer|nullable' : 'prohibited',
            'email' => $addressEmailRules,
            'receiverName' => $addressStringRules,
            'receiverCountryCodeId' => $addressStringRules,
            'receiverPhoneNumber' => $addressStringRules,
            'addressLineOne' => $addressStringRules,
            'addressLineTwo' => 'string|nullable',
            'postcode' => $addressStringRules,
            'city' => $addressStringRules,
            'state' => $addressStringRules,
            'countryId' => $addressNumberRules,
            'promoCode' => $isLoggedIn ? 'string|nullable' : 'prohibited',
            'notes' => 'string|nullable',
            'addAddress' => 'boolean|required',
            'paymentOptionId' => 'integer|required'
        ];
    }
}
