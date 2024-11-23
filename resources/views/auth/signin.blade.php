@extends('layout')
@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">>{{ $error }}</div>
    @endforeach
@endif
<form action="/auth/authenticate" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
    </div>
    <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-check-input" name="remember">
        <label for="remember" class="form-check-label">Stay logged in</label>
        
    </div>
    <button type="submit" class="btn btn-primary">SignUp</button>
</form>
@endsection