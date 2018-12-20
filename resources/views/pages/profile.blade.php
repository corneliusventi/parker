@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="{{ $user->fullname }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ $user->username }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="New Password Confirmation">
        </div>
        <button type="submit" name="login" id="login" class="btn btn-primary btn-block rounded">Update</button>
    </form>
@endsection
