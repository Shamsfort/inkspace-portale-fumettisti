<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\MediaStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly MediaStorage $mediaStorage)
    {
    }

    public function index(): View
    {
        $users = User::with('profile')
            ->whereHas('articles', fn ($query) => $query->where('is_accepted', true))
            ->orderBy('name')->paginate(12);

        return view('profile.index', compact('users'));
    }

    public function user(User $user): View
    {
        $user->load(['profile', 'articles' => fn ($query) => $query
            ->where('is_accepted', true)->with(['categories', 'rivista'])]);

        return view('profile.user', [
            'user' => $user,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Request $request): View
    {
        return $this->user($request->user());
    }

    public function edit(Request $request): View
    {
        $request->user()->load('profile');
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->update($request->safe()->only(['name', 'username', 'surname', 'email']));

        $profile = $user->profile()->firstOrCreate();
        $profileData = $request->safe()->only(['phone', 'company_address', 'short_description']);

        if ($request->hasFile('image')) {
            $this->mediaStorage->delete($profile->image);
            $profileData['image'] = $this->mediaStorage->store($request->file('image'), 'profiles');
        }

        $profile->update($profileData);

        return redirect()->route('profile.show')->with('message', 'Profilo aggiornato con successo.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->mediaStorage->delete($user->profile?->image);
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'Account eliminato.');
    }

    public function editPassword(): View
    {
        return view('profile.editPassword');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('profile.show')->with('message', 'Password aggiornata.');
    }
}

