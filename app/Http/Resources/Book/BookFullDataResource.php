<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Genre\GenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookFullDataResource extends JsonResource
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
            'genres'         => GenreResource::collection($this->whenLoaded('genres')),
            'type'           => $this->type,
            'published_year' => $this->published_year,
            'description'    => $this->description,
            'created_at'     => $this->created_at,
        ];
    }
}
