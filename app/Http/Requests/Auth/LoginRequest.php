<?php

namespace App\Http\Requests\Auth;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = $validator->errors()->all();
            $response = ApiResponseService::error(message: "Por favor, envie los datos requeridos", errors: $errors);
            throw new ValidationException($validator, $response);
        }
    }

    public function rules(): array
    {

        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El campo email es requerido.',
            'password.unique' => 'El campo password debe ser único. Ya existe un registro con ese nombre.',
        ];
    }
}
