<?php

namespace App\Http\Requests\Book;

use App\Application\Book\Enum\BookTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BookCreateRequest extends FormRequest
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
            'authorId'      => 'required|integer|min:0',
            'title'         => 'required|string',
            'type'          => ['required', new Enum(BookTypeEnum::class)],
            'publishedYear' => 'nullable|integer',
            'description'   => 'nullable|string',
            'genre_ids'     => 'nullable|array',
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
