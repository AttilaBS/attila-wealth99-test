<?php

namespace App\Http\Requests;

use App\Exceptions\CustomException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

final class CreateUserRequest extends FormRequest
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
     * @return array<string,array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The email is already in use!',
        ];
    }

    /**
     * @throws CustomException
     */
    public function failedValidation(Validator $validator): void
    {
        throw new CustomException($validator->errors());
    }
}
