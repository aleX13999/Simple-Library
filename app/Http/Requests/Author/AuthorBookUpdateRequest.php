<?php

namespace App\Http\Requests\Author;

use App\Application\Book\Enum\BookTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorBookUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'sometimes|string|unique:books',
            'type'          => ['sometimes', new Enum(BookTypeEnum::class)],
            'publishedYear' => 'sometimes|integer',
            'description'   => 'sometimes|string',
            'genre_ids'     => 'sometimes|array',
            'genre_ids.*'   => 'integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'genre_ids.*.integer' => 'Genre Ids must be an integer.',
        ];
    }
}
