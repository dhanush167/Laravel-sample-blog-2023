<h3> Laravel Blog Sample </h3>

https://github.com/dhanush167/Laravel-sample-blog-2023/assets/127192609/14c0199a-f173-400e-889a-6c54dabd092e

<hr>

![Capture_img](https://github.com/dhanush167/Laravel-sample-blog-2023/assets/37043938/dc871117-7ee8-4b44-9bf9-0a51784abdae)

```php

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'required',
                Rule::unique('articles', 'title')->ignore($this->article),
                'max:255',
                'min:3',
                'string',
            ],
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('articles', 'slug')->ignore($this->article),
                'max:255',
                'min:3',
                'string',
            ],
            'excerpt' => ['required', 'max:255','min:3', 'string'],
            'description' => ['required', 'string','min:3',],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id','integer'],
            'category_id' => ['required', 'exists:categories,id','integer'],
            'tags' => ['array','nullable'],
            'tags.*' => ['integer',Rule::exists('tags','id')],
        ];
    }
    public function filters(): array {
        return [
            'title' => 'trim|sanitize',
            'slug' => 'trim|lowercase',
            'excerpt' => 'trim|sanitize',
            'description' => 'trim|sanitize',
            'status' => 'trim',
            'user_id' => 'trim|number',
            'category_id' => 'trim|number',
            'tags' => 'trim',
        ];
    }
}


```


```php

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

    private function slugGenerate($slug)
    {
       return ['slug' => \Illuminate\Support\Str::slug($slug),];
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
        $article = Article::create($this->slugGenerate($request->slug) + $request->validated());

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

        $article->update($this->slugGenerate($request->slug) + $request->validated());

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

```













