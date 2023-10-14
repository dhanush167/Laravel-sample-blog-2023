@extends('layouts.front')
@section('content')
    @include('layouts.front_navb')
    <section>
        <div class="container">
            <div class="row">
                <div class="mt-5 col-md-12">
                    <h1 class="text-white fw-bold">{{$article->title}}</h1>
                    <p class="text-white" id="sub_para_single_page">{{$article->user->name}} - {{$article->created_at->format('M jS Y')}} - <span id="lr_para"> {{$article->category->name}} </span></p>
                    <article class="p-3">
                        <div id="ar_para">
                            <p class="fw-bold ms-2">
                                {{$article->excerpt}}
                            </p>
                        </div>
                    </article>
                </div>
                <div class="col col-md-12">
                    <div class="description mt-5">
                        <p>
                            {{$article->description}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div>
                        @foreach($article->tags as $tag)
                           <button class="btn btn-danger me-2" type="button">  #{{$tag->name}}</button>
                        @endforeach
                    </div>
                </div>
                <hr class="mt-5 text-danger">
                <div class="col-md-12">
                    <h1>{{$article->category->name}}</h1>
                    <p>{{$article->category->description}}</p>
                    <a class="btn btn-outline-danger me-2" href="{{route('front-page')}}">RETURN BACK</a>
                </div>
            </div>
        </div>
    </section>
@endsection
