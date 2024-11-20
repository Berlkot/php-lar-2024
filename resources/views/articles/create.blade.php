@extends('layout')
@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">>{{ $error }}</div>
    @endforeach
@endif
    <form action="/articles" method="POST">
        @csrf
        <div  class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
        </div>
        <div  class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div  class="mb-3">
            <label for="desc" class="form-label">Desc</label>
            <input type="text" class="form-control" id="desc" name="desc">
        </div>

        <button type="submit" class="btn btn-primary">Save article</button>
    </form>
@endsection