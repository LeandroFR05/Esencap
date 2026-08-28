<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }


    //Actualización de perfil
    public function update(Request $request)
    {
        $user = Auth::user();
        /** @var User $user */
        assert($user instanceof User);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }



    // Manejo de contraseñas
    public function mostrarCambiarContraseña()
    {
        return view('change-password');
    }

    public function cambiarContraseña(UserRequest $request)
    {
        $user = Auth::user();
        /** @var User $user */
        assert($user instanceof User);

        $user->password = $request->new_password;
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}