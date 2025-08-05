<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->hasRole('admin') || $this->user()->hasRole('author'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName'  => 'sometimes|string',
            'lastName'   => 'sometimes|string',
            'patronymic' => 'sometimes|string',
        ];
    }
}
