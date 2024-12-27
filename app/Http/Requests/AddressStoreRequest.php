<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
        return [
            'zipcode' => 'required|string|max:9',
            'city' => 'required|string|max:255',      
            'state' => 'required|string|max:255',     
            'street'=> 'required|string|max:255',     
            'district'=> 'required|string|max:255',   
            'number'=> 'required|string|max:255',     
            'complement'=> 'nullable|string|max:255', 
        ];
    }
}
