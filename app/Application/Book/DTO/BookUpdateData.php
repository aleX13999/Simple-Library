<?php

namespace App\Application\Book\DTO;

class BookUpdateData
{
    private const AUTHOR_ID      = 'authorId';
    private const TITLE          = 'title';
    private const TYPE           = 'type';
    private const PUBLISHED_YEAR = 'publishedYear';
    private const DESCRIPTION    = 'description';
    private const GENRES         = 'genres';

    private array $data = [];

    public function __construct(
        private readonly int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthorId(): int
    {
        return $this->data[self::AUTHOR_ID];
    }

    public function setAuthorId(int $authorId): static
    {
        $this->data[self::AUTHOR_ID] = $authorId;

        return $this;
    }

    public function hasAuthorId(): bool
    {
        return array_key_exists(self::AUTHOR_ID, $this->data);
    }

    public function getTitle(): string
    {
        return $this->data[self::TITLE];
    }

    public function setTitle(string $title): static
    {
        $this->data[self::TITLE] = $title;

        return $this;
    }

    public function hasTitle(): bool
    {
        return array_key_exists(self::TITLE, $this->data);
    }

    public function getType(): string
    {
        return $this->data[self::TYPE];
    }

    public function setType(string $type): static
    {
        $this->data[self::TYPE] = $type;

        return $this;
    }

    public function hasType(): bool
    {
        return array_key_exists(self::TYPE, $this->data);
    }

    public function getPublishedYear(): ?int
    {
        return $this->data[self::PUBLISHED_YEAR];
    }

    public function setPublishedYear(?int $publishedYear): static
    {
        $this->data[self::PUBLISHED_YEAR] = $publishedYear;

        return $this;
    }

    public function hasPublishedYear(): bool
    {
        return array_key_exists(self::PUBLISHED_YEAR, $this->data);
    }

    public function getDescription(): ?string
    {
        return $this->data[self::DESCRIPTION];
    }

    public function setDescription(?string $description): static
    {
        $this->data[self::DESCRIPTION] = $description;

        return $this;
    }

    public function hasDescription(): bool
    {
        return array_key_exists(self::DESCRIPTION, $this->data);
    }

    public function getGenres(): ?array
    {
        return $this->data[self::GENRES];
    }

    public function setGenres(?array $genres): static
    {
        $this->data[self::GENRES] = $genres;

        return $this;
    }

    public function hasGenres(): bool
    {
        return array_key_exists(self::GENRES, $this->data);
    }
}
