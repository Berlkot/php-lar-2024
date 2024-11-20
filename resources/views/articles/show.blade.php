@extends('layout')
@section('content')
<div class="card" style="width: 18rem;">
    <div class="card-header">
        Author: {{ $author->name }}
    </div>
  <div class="card-body">
    <h5 class="card-title">{{ $article->name }}</h5>
    <p class="card-text">{{ $article->desc }}</p>
    <div class="d-flex justify-content-end gap-3">
        <a href="/articles/{{$article->id}}/edit" class="btn btn-primary">Edit article</a>
        <form action="/articles/{{$article->id}}" method="POST">
            @method("DELETE")
            @csrf
            <button type="submit" class="btn btn-danger">Delete article</button>
        </form>
    </div>
  </div>
</div>
@endsection