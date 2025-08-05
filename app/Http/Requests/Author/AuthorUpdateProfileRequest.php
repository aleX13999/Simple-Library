<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorUpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('author');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'firstName'  => 'sometimes|string',
            'lastName'   => 'sometimes|string',
            'patronymic' => 'sometimes|string',
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes', 'email', 'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => ['sometimes', 'string'],
        ];
    }
}
