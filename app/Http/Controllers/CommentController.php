<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'desc' => 'required|max:256'
        ]);
        $comment = new Comment;
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->article_id = request('article_id');
        $comment->user_id = 1;
        $comment->save();
        return redirect()->back();
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.update', ['comment' => $comment]);
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'name' => 'required|min:3',
            'desc' => 'required|max:256'
        ]);
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->save();
        return redirect()->route('articles.show', ['article' => $comment->article_id]);
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('articles.show', ['article' => $comment->article_id])->with('status', 'Delete success');
    }
}
