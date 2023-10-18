@extends('layouts.front')
@section('content')
    @include('layouts.front_navb')
    @php $editing = isset($article) @endphp
    <div class="container wrapper">
        <div class="row">
            <form method="POST" action="{{ route('store-data-article') }}" class="mt-4 bg-dark p-5">
                @csrf
                @include('front.form')
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
