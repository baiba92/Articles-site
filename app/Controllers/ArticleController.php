<?php declare(strict_types=1);

namespace ArticlesApp\Controllers;

use ArticlesApp\Core\View;
use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Models\Article;
use ArticlesApp\Models\Author;
use ArticlesApp\Services\Article\CreateArticleService;
use ArticlesApp\Services\Article\DeleteArticleService;
use ArticlesApp\Services\Article\IndexArticleService;
use ArticlesApp\Services\Article\Show\ShowArticleServiceRequest;
use ArticlesApp\Services\Article\Show\ShowArticleService;
use ArticlesApp\Services\Article\UpdateArticleService;

class ArticleController
{
    private ShowArticleService $showArticleService;
    private IndexArticleService $indexArticleService;
    private UpdateArticleService $updateArticleService;
    private DeleteArticleService $deleteArticleService;
    private CreateArticleService $createArticleService;

    public function __construct
    (
        ShowArticleService $showArticleService,
        IndexArticleService $indexArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService,
        CreateArticleService $createArticleService
    )
    {
        $this->showArticleService = $showArticleService;
        $this->indexArticleService = $indexArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->deleteArticleService = $deleteArticleService;
        $this->createArticleService = $createArticleService;
    }


    public function home(): View
    {
        try {
            $all = $this->indexArticleService->execute();
            $articles = array_slice($all, 0, 9);
            $first = array_shift($articles);

            return new View('index', [
                'first' => $first,
                'articles' => $articles
            ]);

        } catch (ResourceNotFoundException $exception) {
            //return new View ('notFound', []);
        }
    }

    public function index(): View
    {
        $articles = $this->indexArticleService->execute();

        return new View('articles', [
            'articles' => $articles
        ]);
    }

    public function show(): ?View
    {
        try {
            $articleId = (int)$_GET['articleId'];
            $response = $this->showArticleService->execute(new ShowArticleServiceRequest($articleId));

            return new View('singleArticle', [
                'article' => $response->getArticle(),
                'comments' => $response->getComments()
            ]);
        } catch (ResourceNotFoundException $exception) {
            //return new View ('notFound', []);
        }
    }

    public function createForm(): View
    {
        return new View('createArticleForm', []);
    }

    public function create(): View
    {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $this->createArticleService->execute($title, $content);

        $response = $this->indexArticleService->execute();
        /** @var Article $article */
        $article = end($response);
        $author = new Author($article->authorId(), $name);
        $article->setAuthor($author);

        return new View('createArticleSuccess', [
            'article' => $article
        ]);
    }

    public function editForm(): View
    {
        $articleId = (int)$_GET['articleId'];
        $response = $this->showArticleService->execute(new ShowArticleServiceRequest($articleId));

        return new View('editArticleForm', [
            'article' => $response->getArticle()
        ]);
    }

    public function edit(): View
    {
        $id = (int) $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $this->updateArticleService->execute($id, $title, $content);

        $response = $this->showArticleService->execute(new ShowArticleServiceRequest($id));

        return new View('editArticleSuccess', [
            'article' => $response->getArticle()
        ]);
    }

    public function delete(): View
    {
        $articleId = (int) $_POST['articleId'];

        $this->deleteArticleService->execute($articleId);

        return $this->index();
    }

}
