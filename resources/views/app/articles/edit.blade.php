@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('articles.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
              <span class="text-success"> @lang('crud.articles.edit_title') </span>
            </h4>

            <x-form
                method="PUT"
                action="{{ route('articles.update', $article) }}"
                class="mt-4"
            >
                @include('app.articles.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('articles.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('articles.create') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
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
