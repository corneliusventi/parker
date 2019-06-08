<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'alpha_dash', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if ($request->new_password) {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        }
        return redirect()->route('profile')->withStatus('Profile has been updated');
    }

    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo' => ['required', 'image'],
        ]);

        $photo = base64_encode(file_get_contents($request->photo));

        $user->update([
            'photo' => $photo,
        ]);

        return redirect()->route('profile')->withStatus('Photo Profile has been updated');
    }
}
