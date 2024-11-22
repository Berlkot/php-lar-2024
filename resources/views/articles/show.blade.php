@extends('layout')
@section('content')
@if(session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">>{{ $error }}</div>
  @endforeach
@endif

<div class="card" style="width: 70rem;">
  <div class="card-header">
    Author: {{ $author->name }}
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $article->name }}</h5>
    <p class="card-text">{{ $article->desc }}</p>
    <div class="d-flex">
      <a href="/articles/{{$article->id}}/edit" class="btn btn-primary">Edit article</a>
      <form action="/articles/{{$article->id}}" method="POST">
        @method("DELETE")
        @csrf
        <button type="submit" class="btn btn-danger mx-1">Delete article</button>
      </form>
    </div>
  </div>
  <h4 class="text-center">Add Comment</h4>

  <form action="/comment" method="POST" class="mx-3">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3">
      <label for="desc" class="form-label">Description</label>
      <input type="text" class="form-control" id="desc" name="desc">
    </div>
    <input type="hidden" name="article_id" value="{{ $article->id }}">
    <button type="submit" class="btn btn-primary">Save comment</button>
  </form>

  <h4 class="text-center">Comments</h4>
    @foreach($comments as $comment)
      <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{$comment->name}}</h5>
        <p class="card-text">{{$comment->desc}}</p>
        <a href="/comment/{{$comment->id}}/edit" class="btn btn-primary">Edit comment</a>
        <a href="/comment/{{$comment->id}}/delete" class="btn btn-danger">Delete comment</a>
      </div>
  @endforeach
  </div>
  @endsection