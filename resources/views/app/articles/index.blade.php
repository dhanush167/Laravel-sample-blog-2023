@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="input-group">
                        <input
                            id="indexSearch"
                            type="text"
                            name="search"
                            placeholder="{{ __('crud.common.search') }}"
                            value="{{ $search ?? '' }}"
                            class="form-control"
                            autocomplete="off"
                            required
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon ion-md-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\Article::class)
                <a
                    href="{{ route('articles.create') }}"
                    class="btn btn-primary"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.articles.index_title')</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.articles.inputs.title')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.slug')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.excerpt')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.description')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.status')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.user_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.articles.inputs.category_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->title ?? '-' }}</td>
                            <td>{{ $article->slug ?? '-' }}</td>
                            <td>{!! \Illuminate\Support\Str::limit($article->excerpt,30) ?? '-'  !!}</td>
                            <td>{!! \Illuminate\Support\Str::limit($article->description,30)  ?? '-' !!} </td>
                            <td>{{ $article->status ? 'active' : 'inactive' }}</td>
                            <td>{{ optional($article->user)->name ?? '-' }}</td>
                            <td>
                                {{ optional($article->category)->name ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $article)
                                    <a
                                        href="{{ route('articles.edit', $article) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $article)
                                    <a
                                        href="{{ route('articles.show', $article) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $article)
                                            <form>
                                                <a
                                                    class="btn btn-light text-danger"
                                                    data-target="#deleteModal_{{$article->id}}"
                                                    data-toggle="modal"
                                                >
                                                    <i class="icon ion-md-trash"></i>
                                                </a>
                                            </form>
                                            <div class="modal fade" id="deleteModal_{{$article->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-modal">No</button>
                                                            <form
                                                                action="{{ route('articles.destroy', $article) }}"
                                                                method="POST"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">{!! $articles->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
