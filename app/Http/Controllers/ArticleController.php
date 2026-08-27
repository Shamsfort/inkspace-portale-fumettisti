<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleStoreRequet;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Riviste;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with(['user.profile', 'categories', 'rivista'])
            ->where('is_accepted', true)->latest()->paginate(12);

        return view('article.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        $article->load(['user.profile', 'categories', 'rivista']);
        abort_unless(
            $article->is_accepted || auth()->id() === $article->author_id || auth()->user()?->is_revisor,
            404
        );

        return view('article.show', compact('article'));
    }

    public function create(): View
    {
        return view('article.create', [
            'categories' => Category::orderBy('name')->get(),
            'rivistas' => Riviste::orderBy('nome')->get(),
        ]);
    }

    public function store(ArticleStoreRequet $request): RedirectResponse
    {
        $data = $request->safe()->except('categories');
        $data['author_id'] = $request->user()->id;
        $data['category_id'] = $request->validated('categories')[0];
        $data['image'] = $request->file('image')->store('covers', 'public');
        $data['is_accepted'] = true;

        $article = Article::create($data);
        $article->categories()->sync($request->validated('categories'));

        return redirect()->route('article.show', $article)
            ->with('message', 'Fumetto pubblicato con successo.');
    }

    public function edit(Article $article): View
    {
        $this->ensureOwner($article);
        $article->load('categories');

        return view('article.edit', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
            'rivistas' => Riviste::orderBy('nome')->get(),
        ]);
    }

    public function update(ArticleUpdateRequest $request, Article $article): RedirectResponse
    {
        $this->ensureOwner($article);
        $data = $request->safe()->except('categories');
        $data['category_id'] = $request->validated('categories')[0];

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('covers', 'public');
        }

        $article->update($data);
        $article->categories()->sync($request->validated('categories'));

        return redirect()->route('article.show', $article)
            ->with('message', 'Fumetto aggiornato con successo.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->ensureOwner($article);
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('article.index')->with('message', 'Fumetto eliminato.');
    }

    public function byUser(User $user): View
    {
        $articles = $user->articles()->with(['categories', 'rivista'])
            ->where('is_accepted', true)->latest()->get();

        return view('article.byUser', compact('articles', 'user'));
    }

    private function ensureOwner(Article $article): void
    {
        abort_unless(auth()->id() === $article->author_id, 403, 'Puoi modificare solo i tuoi fumetti.');
    }
}
