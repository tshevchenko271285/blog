@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Your Profile</h3>
                @isset($user)

                    <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="name">Username</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') ? old('name') : $user->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') ? old('email') : $user->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input name="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" value="{{ old('firstname') ? old('firstname') : $user->firstname }}">
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" value="{{ old('lastname') ? old('lastname') : $user->lastname }}">
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <label for="avatar">{{ __('Avatar') }}</label>
                            <div class="row">
                                <div class="col-4">
                                    @if( $user->avatar )
                                        <div class="avatar">
                                            <img src="{{ asset(Storage::url($user->avatar->path)) }}" alt="" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">

                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}">
                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>

                @endisset
            </div>
        </div>
    </div>
@endsection
