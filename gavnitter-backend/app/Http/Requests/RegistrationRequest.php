<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationRequest extends FormRequest
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
            'user.email' => 'required|unique:users,email|email',
            'user.login' => 'required|unique:users,name|min:3',
            'user.password' => 'required|min:8|confirmed',
        ];

    }

    public function messages()
    {
        return [
            'user.email.required' => 'The email field is required.',
            'user.email.unique' => 'The field email must be unique.',
            'user.login.required' => 'The field Login is required.',
            'user.login.min' => 'The field Login must be at least 3 characters.',
            'user.password.required' => 'The field password is required.',
            'user.password.min' => 'The field password must be at least 8 characters.',
            'user.password.confirmed' => 'The field Password under validation must have a matching field of repeat password',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' =>  $errors->toArray(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
