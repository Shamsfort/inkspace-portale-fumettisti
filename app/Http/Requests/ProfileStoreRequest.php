<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
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
            'name' => ['required','string','max:30'],
            'email' => ['required','string', 'email','max:30'],
            'phone' => ['nullable','string','max:15'],
            'company_address' => ['nullable','string','max:30'],
            'short_description' => ['nullable','string','max:100'],
            'image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg','max:12024'],
        ];


        
    }

    public function messages(){
        return [
            'name.required' => 'Il nome è richiesto',
            'email.required' => 'Email obbligatoria',
            'email.email' => 'Formato email non valido',
            'email.max' => 'il campo email non può avere più di 30 caratteri',
            'phone.max' => 'Il campo telefono non può avere più di 15 caratteri',
            'company_address.max' => 'Il campo indirizzo non può avere più di 30 characters',
            'short_description.max' => 'il campo bio non può avere più di 100 characters',
            'image.mimes' => 'Solo jpeg, png, jpg, gif, svg sono permessi',
            'image.max' => 'La foto non può pesare più di 12Mb',

        ];
    }
}
