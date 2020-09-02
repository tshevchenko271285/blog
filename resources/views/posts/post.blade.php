@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{url()->previous()}}" type="submit" class="btn btn-primary">Back</a>

                @isset($post)
                    <div class="dashboard-post">
                        @if( $post->thumbnail )
                            <div class="dashboard-post__image">
                                <img src="{{ asset(Storage::url($post->thumbnail->path)) }}" alt="{{$post->title}}">
                            </div>
                        @endif
                        <h3 class="dashboard-post__title">{{$post->title}}</h3>
                        <p class="dashboard-post__description">{{$post->description}}</p>
                        <p class="dashboard-post__content">{{$post->content}}</p>
                        <div class="dashboard-post__footer">
                            Posted on: {{$post->created_at}}
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>
@endsection
