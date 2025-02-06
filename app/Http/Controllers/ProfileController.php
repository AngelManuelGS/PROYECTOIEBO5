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
    /**
     * Display the user's profile form.
     */

     public function index()
    {
        $user = auth()->user(); // Obtiene el usuario autenticado

        return view('profile.edit', compact('user'));
    }
    public function edit(Request $request): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));

    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = Auth::user();

    // Validar los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'telefono' => 'nullable|string|max:15',
        'direccion' => 'nullable|string|max:255',
        'plante_educativo' => 'nullable|string|max:255',
        'region' => 'nullable|string|max:255',
    ]);

    // Actualizar usuario
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Si el usuario tiene un cliente asociado, actualizar su información
    if ($user->cliente) {
        $user->cliente->update([
            'nombre' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'plante_educativo' => $request->plante_educativo,
            'region' => $request->region,
        ]);
    }

    return redirect()->route('profile.edit')->with('status', 'Perfil actualizado correctamente.');
}


    /**
     * Delete the user's account.
     */
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
