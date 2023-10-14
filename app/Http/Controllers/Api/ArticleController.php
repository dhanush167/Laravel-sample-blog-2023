<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{
    public function index(Request $request): ArticleCollection
    {
        $this->authorize('view-any', Article::class);

        $search = $request->get('search', '');

        $articles = Article::search($search)
            ->latest()
            ->paginate();

        return new ArticleCollection($articles);
    }

    public function store(ArticleStoreRequest $request): ArticleResource
    {
        $this->authorize('create', Article::class);

        $validated = $request->validated();

        $article = Article::create($validated);

        return new ArticleResource($article);
    }

    public function show(Request $request, Article $article): ArticleResource
    {
        $this->authorize('view', $article);

        return new ArticleResource($article);
    }

    public function update(
        ArticleUpdateRequest $request,
        Article $article
    ): ArticleResource {
        $this->authorize('update', $article);

        $validated = $request->validated();

        $article->update($validated);

        return new ArticleResource($article);
    }

    public function destroy(Request $request, Article $article): Response
    {
        $this->authorize('delete', $article);

        $article->delete();

        return response()->noContent();
    }
}
