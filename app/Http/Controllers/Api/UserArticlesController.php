<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class UserArticlesController extends Controller
{
    public function index(Request $request, User $user): ArticleCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $articles = $user
            ->articles()
            ->search($search)
            ->latest()
            ->paginate();

        return new ArticleCollection($articles);
    }

    public function store(Request $request, User $user): ArticleResource
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
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $article = $user->articles()->create($validated);

        return new ArticleResource($article);
    }
}
