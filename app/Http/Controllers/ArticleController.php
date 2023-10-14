<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{
    private function getFormData()
    {
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name','id');
        $tags = Tag::get();
        return compact('categories','tags','users');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Article::class);

        $search = $request->get('search', '');

        $articles = Article::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.articles.index', compact('articles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Article::class);
        return view('app.articles.create',$this->getFormData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Article::class);
        $article = Article::create(['slug' => \Illuminate\Support\Str::slug($request->slug),] + $request->validated());

        $article->tags()->attach($request->tags);

        return redirect()
            ->route('articles.edit', $article)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Article $article): View
    {
        $this->authorize('view', $article);

        return view('app.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Article $article): View
    {
        $this->authorize('update', $article);
        return view('app.articles.edit', array_merge(compact('article'), $this->getFormData()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ArticleUpdateRequest $request,
        Article $article
    ): RedirectResponse {
        $this->authorize('update', $article);

        $article->tags()->sync($request->tags);

        $article->update(['slug' => \Illuminate\Support\Str::slug($request->slug),] + $request->validated());

        return redirect()
            ->route('articles.edit', $article)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Article $article
    ): RedirectResponse {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
