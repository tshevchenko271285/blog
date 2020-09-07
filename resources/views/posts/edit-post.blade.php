@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{url()->previous()}}" type="submit" class="btn btn-primary">Back</a>
                <form action="{{route('posts.destroy', ['post' => $post->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </div>

            <form method="POST" action="{{route('posts.update', ['post' => $post->id])}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') ? old('title') : $post->title }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input name="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail">

                    @error('thumbnail')
                       <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Example textarea</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description') ? old('description') : $post->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                @if( $tags && count( $tags ) )
                    <div class="row">
                        @foreach( $tags as $tag )
                            <div class="col-3">
                                <div class="form-group">
                                    <input
                                        type="checkbox"
                                        name="tags[]"
                                        value="{{ $tag->id }}"
                                        id="tag_{{$tag->id}}"
                                        {{ $tag->checked ? 'checked' : ''}}
                                    >
                                    <label for="tag_{{$tag->id}}">{{$tag->name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Save</button>

            </form>

        </div>
    </div>
</div>
@endsection
