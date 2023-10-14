@extends('layouts.front')
@section('content')
   @include('layouts.front_navb')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mb-5">
                    <a class="btn btn-danger mt-5" href="{{route('create-article')}}">Create Article +</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-5">
                    <div class="filter p-1 rounded rounded-5">
                        <ul class="list-unstyled d-flex pt-2 ps-2">
                            <li class="badge bg-success mt-2 fs-6">Latest</li>
                            <li class="badge bg-warning mt-2 fs-6">Oldest</li>
                            <li class="badge bg-info mt-2 fs-6">Category</li>
                            <li class="badge bg-dark mt-2 fs-6">Tag</li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($message=Session::get('message'))
                <div class="alert alert-success">
                    <p>{{$message}}</p>
                </div>
            @endif
            @isset($articles)
              @if($articles->count() > 0)
                 @forelse($articles as $article)
                        <div class="row"><div class="col col-md-6">
                                <h1 class="text-white"><a href="{{route('single-blog',$article->slug)}}">{{$article->title}}</a></h1>
                                <p class="text-white">
                                    {{$article->excerpt}}
                                </p>
                                @if($article->count() > 0)
                                    @foreach($article->tags as $tag)
                                        <a href="#" class="btn btn-danger me-2">#{{$tag->name}}</a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col col-md-6">
                                <p class="fs-3 text-end text-white">{{$article->created_at->format('M jS Y')}}. by {{$article->user->name}}</p>
                            </div>
                            <hr class="mt-4 text-white">
                        </div>
                    @empty
                        <p>
                            You have not yet created any new posts
                        </p>
               @endforelse
              @endif
            @endisset
        </div>
    </section>
@endsection
