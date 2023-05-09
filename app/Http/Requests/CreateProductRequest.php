<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => [
                'required',
                Rule::when(
                    request()->file('image'),
                    'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'string'
                )
            ],
            'categories_ids' => 'required|array|exists:categories,id'
        ];
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'      => $validator->errors()
        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
