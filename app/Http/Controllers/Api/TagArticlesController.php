<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;

class TagArticlesController extends Controller
{
    public function index(Request $request, Tag $tag): ArticleCollection
    {
        $this->authorize('view', $tag);

        $search = $request->get('search', '');

        $articles = $tag
            ->articles()
            ->search($search)
            ->latest()
            ->paginate();

        return new ArticleCollection($articles);
    }

    public function store(
        Request $request,
        Tag $tag,
        Article $article
    ): Response {
        $this->authorize('update', $tag);

        $tag->articles()->syncWithoutDetaching([$article->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Tag $tag,
        Article $article
    ): Response {
        $this->authorize('update', $tag);

        $tag->articles()->detach($article);

        return response()->noContent();
    }
}
