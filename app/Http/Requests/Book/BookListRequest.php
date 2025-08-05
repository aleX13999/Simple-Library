<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookListRequest extends FormRequest
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
            'skip'             => 'sometimes|integer|min:0',
            'take'             => 'sometimes|integer|min:1',
            'author_id'        => 'sometimes|int|min:1',
            'title'            => 'sometimes|string|max:255',
            'genre_ids'        => 'sometimes|array',
            'genre_ids.*'      => 'integer',
            'is_sort_by_title' => 'sometimes|boolean',
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
