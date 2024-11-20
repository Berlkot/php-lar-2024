@extends('layout')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>

@endif
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Date</th>
        <th scope="col">Name</th>
        <th scope="col">Shortdesc</th>
        <th scope="col">User</th>
        <th scope="col">Preview image</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
            <tr>
            <th scope="row">{{ $article->date }}</th>
            <td><a href="/articles/{{$article->id}}">{{ $article->name }}</a></td>
            <td>{{$article->desc}}</td>
            <td>
            @php
            echo \App\Models\User::findOrFail($article->user_id)->name
            @endphp
            </td>
            <!-- <td><a href="gallery/{{$article->full_image}}/{{$article->name}}"><img src="{{$article->preview_image}}" alt="" class="img-thumbnail"></a></td>
             --></tr>
        @endforeach
    </tbody>
    </table>
    {{$articles->links()}}
@endsection