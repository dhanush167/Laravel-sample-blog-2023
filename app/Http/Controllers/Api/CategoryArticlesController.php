<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class CategoryArticlesController extends Controller
{
    public function index(
        Request $request,
        Category $category
    ): ArticleCollection {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $articles = $category
            ->articles()
            ->search($search)
            ->latest()
            ->paginate();

        return new ArticleCollection($articles);
    }

    public function store(Request $request, Category $category): ArticleResource
    {
        $this->authorize('create', Article::class);

        $validated = $request->validate([
            'title' => [
                'required',
                'unique:articles,title',
                'max:255',
                'string',
            ],
            'slug' => ['required', 'unique:articles,slug', 'max:255', 'string'],
            'excerpt' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $article = $category->articles()->create($validated);

        return new ArticleResource($article);
    }
}
