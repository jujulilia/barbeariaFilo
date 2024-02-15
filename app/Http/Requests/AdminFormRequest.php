<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminFormRequest extends FormRequest
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
            'name' => 'required|max:120|min:5 ',
            'email' => 'required|max:120|unique:administradors,email|email:rfc,dns',
            'cpf' => 'required|unique:administradors,cpf|max:11|min:11',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => "O campo name é obrigatorio",
            'name.max' => 'O campo name deve conter no máximo 120 caracteres',
            'name.min' => 'O campo name deve conter no minimo 5 caracteres',

            'email.required' => 'Email obrigatorio',
            'email.max' => 'O campo e-mail deve conter no máximo 120 caracteres',
            'email.email' => 'Formato de email invalido',
            'email.unique' => 'E-mail já cadastrado',

            'cpf.required' => 'CPF obrigatório',
            'cpf.max' => 'CPF deve conter no máximo 11 caracteres',
            'cpf.min' => 'CPF deve conter no mínimo 11 caracteres',
            'cpf.unique' => 'CPF Já cadastrado no sistema',

            'password.required' => 'password obrigatoria'
        ];
    }
}
