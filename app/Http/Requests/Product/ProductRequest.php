<?php

namespace App\Http\Requests\Product;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
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
            'nombre' => 'required|unique:products,nombre',
            'category_id' => 'required|exists:categories,id',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
            'image' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'category_id.required' => 'El campo category_id es requerido.',
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.unique' => 'El campo nombre debe ser único. Ya existe un registro con ese nombre.',
            'descripcion.required' => 'El campo descripcion es requerido.',
            'precio.required' => 'El campo precio es requerido.',
            'cantidad.required' => 'El campo cantidad es requerido.',
            'image.required' => 'El campo image es requerido.',
            'category_id.exists' => 'El campo category_id debe existir en la tabla de categorías.',
        ];
    }
}
