@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{route('home')}}" class="btn btn-primary">Back</a>
                <a href="{{route('tags.create')}}" class="btn btn-outline-primary">Add Tag</a>


                @isset($tags)

                    <ul class="dashboard-tags">
                        @foreach($tags as $tag)
                            <li class="dashboard-tag">
                                <a href="{{route('tags.edit', [ 'tag' => $tag->id ])}}">{{ $tag->name }}</a>
                            </li>
                        @endforeach
                    </ul>

                @endisset

            </div>
        </div>
    </div>
@endsection
