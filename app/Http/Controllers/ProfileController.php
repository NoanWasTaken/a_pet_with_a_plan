<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Affiche le formulaire de profil de l'utilisateur.
    public function edit(Request $request): View
    {
        return view('public.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Met à jour les informations de profil de l'utilisateur.
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Convertir les valeurs des checkboxes en booléens
        $validated['aime_chiens'] = (bool) ($validated['aime_chiens'] ?? false);
        $validated['aime_chats'] = (bool) ($validated['aime_chats'] ?? false);
        
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Supprime le compte de l'utilisateur.
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
