<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\Book\BookResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorWithBooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'books_count' => $this->when(isset($this->books_count), $this->books_count),
            'books'       => BookResource::collection($this->whenLoaded('books')),
        ];
    }
}
