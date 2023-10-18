
@extends('layouts.front')
@section('content')
@include('layouts.front_navb')
<form method="POST" action="{{ route('article_update',$article->slug) }}" class="mt-4 bg-dark p-5">
    @csrf
    @method('PATCH')
    @include('front.form')
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
