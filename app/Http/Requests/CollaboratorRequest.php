<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorRequest extends FormRequest
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
            'firstname' => ['required' , 'min:3' , 'string'],
            'lastname' => ['required' , 'min:3' , 'string'],
            'email' => ['required','email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'serial_number' => ["nullable", 'unique:users,serial_number'],
            'sex' => ["required"],
            'birthday' => ["required"],
        ];
    }
}
