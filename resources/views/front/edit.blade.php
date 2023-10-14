
@extends('layouts.front')
@section('content')
@include('layouts.front_navb')
<form method="POST" action="{{ route('article_update',$article->slug) }}" class="mt-4 bg-dark p-5">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="form-group col-sm-12 mb-2">
            <label for="excerpt" class="form-label">Title</label>
            <input
                class="form-control"
                type="text"
                name="title"
                label="Title"
                value="{{ $article->title }}"
                maxlength="255"
                placeholder="Title"
                required>
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="col-sm-12 mb-2 form-group">
            <label for="excerpt" class="form-label">Excerpt</label>
            <textarea
                class="form-control"
                name="excerpt"
                maxlength="255"
                required>{{ $article->excerpt }}</textarea>
            @if ($errors->has('excerpt'))
                <span class="text-danger">{{ $errors->first('excerpt') }}</span>
            @endif
        </div>
        <div class="col-sm-12 mb-2 form-group">
            <label for="description" class="form-label">Description</label>
            <textarea
                rows="10"
                name="description"
                class="form-control"
                label="Description"
                required>{{ $article->description }}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <div class="col-sm-12 mb-3 form-group mt-5">
            <label for="description" class="form-label">Categories</label>
            <select class="form-select" name="category_id" label="Category" required>
                @foreach($categories as $key => $value)
                    <option value="{{ $key }}" {{ $article->category_id === $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <span class="text-danger">{{ $errors->first('category_id') }}</span>
            @endif
        </div>
        <div class="form-group col-sm-12 mt-4 mb-2">
            <h4>Assign @lang('crud.tags.name')</h4>
            @foreach ($tags as $tag)
                <div>
                    <input
                        type="checkbox"
                        id="tag{{ $tag->id }}"
                        name="tags[]"
                        label="{{ ucfirst($tag->name) }}"
                        value="{{ $tag->id }}"
                        @isset($article) @if($article->tags()->where('id', $tag->id)->exists()) checked @endif @endisset>
                    <label class="form-check-label" for="flexCheckDefault">
                        {{ ucfirst($tag->name) }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('front-page') }}"
            class="btn btn-success border border-2 border-black">
            <i class="icon ion-md-return-left text-primary"></i>
            @lang('crud.common.back')
        </a>

        <button type="submit" class="btn btn-danger bg-danger text-white float-right">
            <i class="icon ion-md-save bg-danger"></i>
            @lang('crud.common.update')
        </button>
    </div>
</form>

@endsection
