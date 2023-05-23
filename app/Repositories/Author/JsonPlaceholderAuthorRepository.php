<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Author;

use ArticlesApp\Cache;
use ArticlesApp\Models\Author;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class JsonPlaceholderAuthorRepository implements AuthorRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function fetchAuthors(): array
    {
        try {
            if (!Cache::has('authors')) {
                $response = $this->client->get('https://jsonplaceholder.typicode.com/users');
                $responseJson = $response->getBody()->getContents();
                Cache::save('authors', $responseJson);
            } else {
                $responseJson = Cache::get('authors');
            }

            $authorContent = json_decode($responseJson);
            return $this->createAuthorsCollection((array)$authorContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSingleAuthor(int $id): ?Author
    {
        try {
            if (!Cache::has('author_' . $id)) {
                $response = $this->client->get("https://jsonplaceholder.typicode.com/users/$id");
                $responseJson = $response->getBody()->getContents();
                Cache::save('author_' . $id, $responseJson);
            } else {
                $responseJson = Cache::get('author_' . $id);
            }

            $authorContent = json_decode($responseJson);
            return $this->createAuthor($authorContent);

        } catch (GuzzleException $exception) {
            return null;
        }
    }

    private function createAuthorsCollection(array $authors): array
    {
        $collection = [];
        foreach ($authors as $author) {
            $collection[] = $this->createAuthor($author);
        }
        return $collection;
    }

    private function createAuthor(stdClass $authorContent): Author
    {
        return new Author(
            $authorContent->id,
            $authorContent->name,
            $authorContent->username,
            $authorContent->email,
            $authorContent->website,
            $authorContent->address->city,
            $authorContent->company->name
        );
    }
}