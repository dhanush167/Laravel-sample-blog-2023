@extends('layouts.front')
@section('content')
    @include('layouts.front_navb')
    @php $editing = isset($article) @endphp
    <div class="container wrapper">
        <div class="row">
            <form method="POST" action="{{ route('store-data-article') }}" class="mt-4 bg-dark p-5">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-12 mb-2">
                        <label for="excerpt" class="form-label">Title</label>
                        <input
                            class="form-control"
                            type="text"
                            name="title"
                            label="Title"
                            value=""
                            maxlength="255"
                            placeholder="Title"
                            required>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12 mb-2">
                        <label for="excerpt" class="form-label">Slug</label>
                        <input
                            class="form-control"
                            type="text"
                            name="slug"
                            label="Slug"
                            value=""
                            maxlength="255"
                            placeholder="Slug"
                            required
                        >
                        @if ($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 form-group">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea
                            class="form-control"
                            name="excerpt"
                            maxlength="255"
                            required></textarea>
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
                            required></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-3 form-group mt-3">
                        <select class="form-select" name="user_id" label="User" required>
                            @php $selected = old('user_id', ($editing ? $article->user_id : '')) @endphp
                            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
                            @foreach($users as $value => $label)
                                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('user_id'))
                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-3 form-group mt-3">
                        <select class="form-select" name="category_id" label="Category" required>
                            @php $selected = old('category_id', ($editing ? $article->category_id : '')) @endphp
                            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
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
                                    class="form-check-input border border-3 border-black text-dark"
                                    id="tag{{ $tag->id }}"
                                    name="tags[]"
                                    label="{{ ucfirst($tag->name) }}"
                                    value="{{ $tag->id }}"
                                >
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ ucfirst($tag->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('front-page') }}" class="btn btn-success border border-2 border-black">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>
                    <button type="submit" class="btn btn-danger bg-danger text-white float-right">
                        <i class="icon ion-md-save bg-danger"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
