@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <a href="{{route('home')}}" type="submit" class="btn btn-primary">Back</a>

            <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input name="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" value="{{ old('thumbnail') }}">
                    @error('thumbnail')
                       <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Example textarea</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description') }}</textarea>
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
                                        name="tags[{{$loop->index}}]"
                                        value="{{ $tag->id }}"
                                        id="tag_{{$tag->id}}"
                                        {{ ( old('tags.'.$loop->index) ) ? 'checked' : ''}}
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
