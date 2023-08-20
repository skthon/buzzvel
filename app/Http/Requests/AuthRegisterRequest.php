<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     =>'required|string',
            'email'    =>'required|string|email|unique:users',
            'password' =>'required|min:8'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'     => 422,
            'messages' => $validator->errors(),
        ], 422));
    }
}
