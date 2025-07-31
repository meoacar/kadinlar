<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Kullanıcı profilini getir
    public function show()
    {
        return response()->json(Auth::user());
    }

    // Profil güncelleme
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'birth_date' => 'date',
            'birth_time' => 'nullable|string|max:10',
            'birth_place' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);
        return response()->json($user);
    }
}
