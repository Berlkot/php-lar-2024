<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use Gate;
use App\Events\NewArticleEvent;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(6);
        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', [self::class]);
        $request->validate([
            'date' => 'date',
            'name' => 'required|min:5|max:100',
            'desc' => 'required|min:5'
        ]);
        $article = new Article();
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;
        if ($article->save()){
            NewArticleEvent::dispatch($article);
            return redirect()->route('articles.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $comments = Comment::where('article_id', $article->id)->where('accept', 1)->latest()->get();
        $author = \App\Models\User::findOrFail($article->user_id);
        return view('articles.show', ['article' => $article, 'author' => $author, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {

        return view('articles.update', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', ['article' => $article]);
        $request->validate([
            'date' => 'date',
            'name' => 'required|min:5|max:100',
            'desc' => 'required|min:5'
        ]);
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;

        if ($article->save())
            return redirect()->route('articles.index')->with('status', 'success');
        else
            return redirect()->route('articles.index')->with('status', 'error');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', ['article' => $article]);
        if ($article->delete())
            return redirect()->route('articles.index')->with('status', 'success');
        else
            return redirect()->route('articles.show', ['article' => $article->id])->with('status', 'error');
    }
}
