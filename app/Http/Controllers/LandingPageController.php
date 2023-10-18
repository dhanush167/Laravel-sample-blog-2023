<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{


    private function getFormData()
    {
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name','id');
        $tags = Tag::all();
        return compact('categories','tags','users');
    }

    public function index()
    {
        $articles = Article::where('status',1)->with(['user','tags'])->latest()->simplePaginate();
        return view('front.index', compact('articles'));
    }

    public function single(Article $article)
    {
        return view('front.single-page', compact('article'));
    }
    public function DashBoard()
    {
        $this->authorize('view', Article::class);
        $articles = \App\Models\Article::where('user_id',auth()->id())->get();
        return view('front.user_dashboard', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        return view('front.create',$this->getFormData());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeFront(StoreArticleRequest $request)
    {
        $this->authorize('create', Article::class);
        $article = Article::create([
            'slug'=>\Illuminate\Support\Str::slug($request->slug),
            'status'=>false,
            'user_id'=>auth()->id(),
            'category_id'=>$request->category_id
        ]+$request->validated());

        $article->tags()->attach($request->tags);
        return redirect(route('front-page'))->with('message','Article has successfully been created');
    }

    public function EditFront(Request $request, Article $article)
    {
        $this->authorize('update', $article);
        return view(
            'front.edit',
            array_merge(compact('article'), $this->getFormData())
        );
    }

    public function UpdateFront(UpdateArticleRequest $request,Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->validated() + [
                'slug' => \Illuminate\Support\Str::slug($request->title)]);

        $article->tags()->sync($request->tags);
        return redirect(route('edit_article',$article))->with('message','Article has Success fully updated');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return redirect(route('dashboard'))->with('message','Article has Success fully deleted');
    }

}
