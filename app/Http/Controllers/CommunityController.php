<?php

namespace App\Http\Controllers;

use App\Models\CommunityComment;
use App\Models\CommunityPost;
use App\Services\MediaStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function index(): View
    {
        $posts = CommunityPost::with(['author:id,name,username', 'images'])
            ->withCount('comments')
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('community.index', compact('posts'));
    }

    public function create(): View
    {
        return view('community.create');
    }

    public function store(Request $request, MediaStorage $mediaStorage): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:2000'],
            'images' => ['required', 'array', 'min:1', 'max:3'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);

        $storedPaths = [];

        try {
            foreach ($request->file('images') as $image) {
                $storedPaths[] = $mediaStorage->store($image, 'community');
            }

            DB::transaction(function () use ($request, $data, $storedPaths) {
                $post = CommunityPost::create([
                    'user_id' => $request->user()->id,
                    'body' => $data['body'],
                    'status' => 'pending',
                ]);

                foreach ($storedPaths as $index => $path) {
                    $post->images()->create([
                    'path' => $path,
                    'position' => $index,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($storedPaths as $path) {
                $mediaStorage->delete($path);
            }

            throw $exception;
        }

        return redirect()->route('community.index')->with('message', 'Post inviato per approvazione.');
    }

    public function show(CommunityPost $communityPost): View
    {
        abort_unless(
            $communityPost->status === 'approved' || auth()->id() === $communityPost->user_id || auth()->user()?->is_admin,
            404
        );

        $communityPost->load(['author:id,name,username', 'images', 'comments.user:id,name,username']);

        return view('community.show', ['post' => $communityPost]);
    }

    public function comment(Request $request, CommunityPost $communityPost): RedirectResponse
    {
        abort_unless($communityPost->status === 'approved', 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        CommunityComment::create([
            'community_post_id' => $communityPost->id,
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        return back()->with('message', 'Commento aggiunto.');
    }
}

