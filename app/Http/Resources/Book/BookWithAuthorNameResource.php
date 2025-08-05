<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookWithAuthorNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'author'         => $this->author->first_name . ' ' . $this->author->last_name,
            'type'           => $this->type,
            'published_year' => $this->published_year,
            'description'    => $this->description,
        ];
    }
}
