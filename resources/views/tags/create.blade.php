@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{route('tags.index')}}" class="btn btn-primary">Back to Tags</a>

                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Tag Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="title" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Tag</button>

                </form>

            </div>
        </div>
    </div>
@endsection
