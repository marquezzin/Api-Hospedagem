<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class GuestUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        //so o usuario logado pode atualizar ele mesmo
        return $this->guest->user->id === auth()->user()->id; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [                         //para ser unico na tabela, com excecao do proprio usuario
            'email'=> ['required','email',Rule::unique('users')->ignore(auth()->user()->id)], 
            'password'=>['nullable','string','min:8','confirmed',Password::min(8)->letters()->uncompromised()->numbers()->mixedCase()], //confirmed indica a necessidade de password_confirmation
            'name' => 'required|string|min:3|max:255',
            'birthdate' => 'required|date|before:now',
            'cpf' => 'required_if:is_foreigner,0|max:11',
            'rg' => 'required_if:is_foreigner,0|max:15',
            'is_foreigner' => 'required|boolean',
            'passport' => 'required_if:is_foreigner,1',
        ];
    }
}
