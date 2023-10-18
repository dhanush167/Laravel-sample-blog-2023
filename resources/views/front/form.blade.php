@php $editing = isset($article) @endphp
@if($message=Session::get('message'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
<div class="row">
    <div class="form-group col-sm-12 mb-2">
        <label for="excerpt" class="form-label">Title</label>
        <input
            class="form-control"
            type="text"
            name="title"
            label="Title"
            value="{{old('title', ($editing ? $article->title : ''))}}"
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
            required>{{ old('excerpt', ($editing ? $article->excerpt : ''))}}</textarea>
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
            required>{{ old('description', ($editing ? $article->description : ''))}}</textarea>
        @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
    </div>
    <div class="col-sm-12 mb-3 form-group mt-5">
        <label for="description" class="form-label">Categories</label>
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
        @if ($errors->has('tags[]'))
            <span class="text-danger">{{ $errors->first('tags[]') }}</span>
        @endif
    </div>
</div>
