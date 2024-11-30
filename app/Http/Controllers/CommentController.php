<?php

namespace App\Http\Controllers;

use App\Jobs\VeryLongJob;
use Auth;
use Gate;
use Illuminate\Http\Request;
use App\Models\Comment;

use App\Mail\NewCommentMail;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', ['comments' => $comments]);
    }
    public function accept(Comment $comment) {
        $comment->accept = true;
        $comment->save();
        return redirect()->route('comments.index');
    }
    public function reject(Comment $comment) {
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comments.index');
    }
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
        $comment->user_id = Auth::id();
        if ($comment->save()){
            VeryLongJob::dispatch($comment);
            return redirect()->back()->with('status', 'Comment sent to moderation');
            };
        return redirect()->back();
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        Gate::authorize('update-comment', ['comment' => $comment]);
        return view('comments.update', ['comment' => $comment]);
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update-comment', ['comment' => $comment]);
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
        Gate::authorize('update-comment', ['comment' => $comment]);
        $comment->delete();
        return redirect()->route('articles.show', ['article' => $comment->article_id])->with('status', 'Delete success');
    }
}
