<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:3',
            'cedula' => 'required|integer|min:8|unique:users',
            'email' => 'required|email|unique:users',
            'p_venta' => 'required|min:3',
            'cargo' => 'required|min:3',
            'password' => 'required|min:6',
        ];
    }
}
