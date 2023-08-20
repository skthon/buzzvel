<?php

namespace App\Api\V1\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'         => 'required|string|between:3,100',
            'description'   => 'required|string|between:10,300',
            'attachments'   => 'array',
            'attachments.*' => 'mimes:pdf,jpg,png,gif,jpeg|max:20000'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'     => 422,
            'message'  => 'Invalid input',
            'errors'   => $validator->errors(),
        ], 422));
    }
}
