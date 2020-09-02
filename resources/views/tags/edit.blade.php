@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{route('tags.index')}}" class="btn btn-primary">Back to Tags</a>

                @isset($tag)

                    <form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="POST">

                        @csrf

                        @method('PUT')

                        <div class="form-group">

                            <label for="title">Tag Name</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="title" value="{{ old('name') ? old('name') : $tag->name }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        @if($tag->posts && count($tag->posts))
                        <h4>Related Pages:</h4>
                        <ul>
                            @foreach($tag->posts as $post)
                                <li><a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a></li>
                            @endforeach
                        </ul>
                        @endif

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>

                @endisset

            </div>
        </div>
    </div>
@endsection
