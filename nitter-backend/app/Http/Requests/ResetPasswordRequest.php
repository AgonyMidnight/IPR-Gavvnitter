<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
            'password.password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.password.required' => 'The field password is required.',
            'password.password.min' => 'The field password must be at least 8 characters.',
            'password.password.confirmed' => 'The field Password under validation must have a matching field of repeat password',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => $errors->toArray() ,//$errors->messages()->,
        ], 422);

        throw new HttpResponseException($response);
    }
}
