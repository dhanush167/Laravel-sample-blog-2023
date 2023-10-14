@extends('layouts.front')
@section('content')
    @include('layouts.front_navb')
    <section>
        <div class="container">
            <div class="row">
                <div class="col col-md-12">
                    <div class="mt-5 mb-5"><a href="{{route('create-article')}}" class="btn btn-danger fw-bold">Create Article +</a>
                        <h1 class="mt-5">Here's a list of your articles :- @if(auth()->user()) {{auth()->user()->name}} @endif</h1>
                    </div>
                </div>
            </div>
            @isset($articles)
              @if($articles->count() > 0)
                 @forelse($articles as $article)
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h4 class="fw-bold">
                                                <a href="{{route('single-blog',$article->slug)}}">
                                                    {{$article->title}}
                                                </a>
                                            </h4>
                                            <h6 class="fw-bold text-success mb-2">Created on {{$article->created_at->format("M jS Y")}}</h6>
                                            <p>
                                                <a href="{{route('single-blog',$article->slug)}}">
                                                {{$article->excerpt}}
                                                </a>
                                            </p>
                                            <form  action="{{route('article_delete',$article->slug)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="me-2 badge bg-danger rounded rounded-3">
                                                    DELETE
                                                </button>
                                            </form>
                                            <a class="badge bg-warning rounded rounded-3" href="{{route('edit_article',$article->slug)}}">
                                                UPDATE
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
