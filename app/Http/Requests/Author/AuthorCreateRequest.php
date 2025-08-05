<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin');
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
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password'   => 'required|string|max:255',
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
        ];
    }
}
