@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('articles.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.articles.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.title')</h5>
                    <span>{{ $article->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.slug')</h5>
                    <span>{{ $article->slug ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.excerpt')</h5>
                    <span>{{ $article->excerpt ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.description')</h5>
                    <span>{{ $article->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.status')</h5>
                    <span>{{ $article->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.user_id')</h5>
                    <span>{{ optional($article->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.articles.inputs.category_id')</h5>
                    <span>{{ optional($article->category)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('articles.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Article::class)
                <a href="{{ route('articles.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\article_tag::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Tags</h4>

            <livewire:article-tags-detail :article="$article" />
        </div>
    </div>
    @endcan
</div>
@endsection
