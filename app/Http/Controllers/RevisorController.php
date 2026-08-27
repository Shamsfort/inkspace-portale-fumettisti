<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class RevisorController extends Controller
{
    public function dashboard()
    {
        $unrevisonedArticles = Article::whereNull('is_accepted')->get();
        $revisonedArticles = Article::where('is_accepted', true)->get();
        $rejectedArticles = Article::where('is_accepted', false)->get();
        
        return view('revisor.dashboard', compact('unrevisonedArticles', 'revisonedArticles', 'rejectedArticles'));
    }

    public function accept(Article $article)
    {
        if (!is_null($article)) {
            $article->is_accepted = true;
            $article->save();
            
            return redirect()->route('revisor.dashboard')->with('message', 'Articolo accettato e pubblicato!');
        } else {
            return redirect()->route('revisor.dashboard')->with('error', 'Articolo non trovato!');
        }
    }

    public function reject(Article $article)
    {
        if (!is_null($article)) {
            $article->is_accepted = false;
            $article->save();
            return redirect()->route('revisor.dashboard')->with('message', 'Articolo rifiutato!');
        } else {
            return redirect()->route('revisor.dashboard')->with('error', 'Articolo non trovato!');
        }
    }

    public function undo(Article $article)
    {
        if (!is_null($article)) {
            $article->is_accepted = null;
            $article->save();
            return redirect()->route('revisor.dashboard')->with('message', 'Articolo ripristinato in revisione!');
        } else {
            return redirect()->route('revisor.dashboard')->with('error', 'Articolo non trovato!');
        }
    }
}
