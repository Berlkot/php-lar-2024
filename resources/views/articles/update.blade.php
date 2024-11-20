@extends('layout')
@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">>{{ $error }}</div>
    @endforeach
@endif
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>

@endif
    <form action="/articles/{{$article->id}}" method="POST">
        @csrf
        @method('PUT')
        <div  class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
        </div>
        <div  class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$article->name}}">
        </div>
        <div  class="mb-3">
            <label for="desc" class="form-label">Desc</label>
            <textarea type="text" class="form-control" id="desc" name="desc">{{$article->desc}}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save article</button>
    </form>
@endsection