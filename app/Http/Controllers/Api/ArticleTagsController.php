<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagCollection;

class ArticleTagsController extends Controller
{
    public function index(Request $request, Article $article): TagCollection
    {
        $this->authorize('view', $article);

        $search = $request->get('search', '');

        $tags = $article
            ->tags()
            ->search($search)
            ->latest()
            ->paginate();

        return new TagCollection($tags);
    }

    public function store(
        Request $request,
        Article $article,
        Tag $tag
    ): Response {
        $this->authorize('update', $article);

        $article->tags()->syncWithoutDetaching([$tag->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Article $article,
        Tag $tag
    ): Response {
        $this->authorize('update', $article);

        $article->tags()->detach($tag);

        return response()->noContent();
    }
}
