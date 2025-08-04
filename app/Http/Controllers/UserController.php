<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        // Update the user data
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return redirect()->route('home')->with('success', 'Perfil atualizado com sucesso!');
    }
}
