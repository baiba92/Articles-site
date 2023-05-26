<?php declare(strict_types=1);

namespace ArticlesApp\Models;

class Article
{
    private int $id;
    private int $authorId;
    private string $title;
    private string $content;
    private string $imageUrl = 'https://placehold.co/600x400';
    private ?Author $author = null;

    public function __construct
    (
        int    $id,
        int    $authorId,
        string $title,
        string $content
    )
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->content = $content;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function authorId(): int
    {
        return $this->authorId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    public function author(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author = null): void
    {
        $this->author = $author;
    }
}