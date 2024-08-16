<?php

namespace App\Http\Requests\Category;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CategoryRequestUpdate extends FormRequest
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
            'nombre' => 'required|unique:categories,nombre,' . $this->route('id'),
            'descripcion' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.unique' => 'El campo nombre debe ser único. Ya existe un registro con ese nombre.',
            'descripcion.required' => 'El campo descripcion es requerido.',
        ];
    }
}
