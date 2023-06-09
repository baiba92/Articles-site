<?php declare(strict_types=1);

namespace ArticlesApp\Models;

class Author
{
    private int $id;
    private string $name;
    private string $imageUrl = 'https://placehold.co/400x400';
    private ?string $userName;
    private ?string $eMail;
    private ?string $website;
    private ?string $homeTown;
    private ?string $workingPlace;

    public function __construct
    (
        int    $id,
        string $name,
        string $userName = null,
        string $eMail = null,
        string $website = null,
        string $homeTown = null,
        string $workingPlace = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->userName = $userName;
        $this->eMail = $eMail;
        $this->website = $website;
        $this->homeTown = $homeTown;
        $this->workingPlace = $workingPlace;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function eMail(): string
    {
        return $this->eMail;
    }

    public function website(): string
    {
        return $this->website;
    }

    public function homeTown(): string
    {
        return $this->homeTown;
    }

    public function workingPlace(): string
    {
        return $this->workingPlace;
    }
}