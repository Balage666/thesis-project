<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Axlon\PostalCodeValidation\Rules\PostalCode;
use Helper;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $phoneNumberRegex = Helper::GetPhoneNumberRegex();
        return [
            'firstName' => ['required', 'min:3'],
            'lastName' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'phoneNumber' => ['required', "regex:$phoneNumberRegex", 'min:9'],
            'fullAddress' => ['required'],
            'address' => ['required'],
            'country' => ['required'],
            'stateOrRegion' => ['required'],
            'zipOrPostalCode' => ['required']
        ];
    }
}
