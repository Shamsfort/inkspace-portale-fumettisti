<?php

namespace App\Http\Controllers;

use App\Models\AdminRequest;
use App\Models\CommunityPost;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommunityAdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.community', [
            'pendingPosts' => CommunityPost::with(['author:id,name,username', 'images'])->where('status', 'pending')->latest()->get(),
            'approvedPosts' => CommunityPost::with('author:id,name,username')->where('status', 'approved')->latest()->limit(12)->get(),
            'rejectedPosts' => CommunityPost::with('author:id,name,username')->where('status', 'rejected')->latest()->limit(12)->get(),
            'adminRequests' => AdminRequest::with('user:id,name,username')->where('status', 'pending')->latest()->get(),
            'admins' => User::query()->where('is_admin', true)->orderBy('name')->get(),
            'contactMessages' => ContactMessage::query()->latest()->limit(50)->get(),
        ]);
    }

    public function approvePost(CommunityPost $communityPost): RedirectResponse
    {
        abort_unless($communityPost->status === 'pending', 409, 'Il post è già stato moderato.');
        $communityPost->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('message', 'Post approvato.');
    }

    public function rejectPost(CommunityPost $communityPost): RedirectResponse
    {
        abort_unless($communityPost->status === 'pending', 409, 'Il post è già stato moderato.');
        $communityPost->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('message', 'Post rifiutato.');
    }

    public function requestAdmin(): RedirectResponse
    {
        abort_if(auth()->user()->is_admin, 422, 'Sei già amministratore.');

        AdminRequest::updateOrCreate(['user_id' => auth()->id()], [
            'status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return back()->with('message', 'Richiesta amministratore inviata.');
    }

    public function approveAdminRequest(AdminRequest $adminRequest): RedirectResponse
    {
        abort_unless($adminRequest->status === 'pending', 409, 'La richiesta è già stata moderata.');

        DB::transaction(function () use ($adminRequest) {
            $adminRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            $adminRequest->user()->update(['is_admin' => true]);
        });

        return back()->with('message', 'Nuovo amministratore approvato.');
    }

    public function rejectAdminRequest(AdminRequest $adminRequest): RedirectResponse
    {
        abort_unless($adminRequest->status === 'pending', 409, 'La richiesta è già stata moderata.');
        $adminRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('message', 'Richiesta amministratore rifiutata.');
    }

    public function resolveContactMessage(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'status' => 'resolved',
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        return back()->with('message', 'Richiesta contatto archiviata come gestita.');
    }
}

