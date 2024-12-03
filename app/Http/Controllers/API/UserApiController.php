<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserDeactivated;
use App\Mail\UserActivated;


class UserApiController extends Controller
{
    
    public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    
    public function indexUser()
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->rol_id = 2;
        $user->p_venta = $request->p_venta;
        $user->cargo = $request->cargo;
        $user->password =bcrypt($request->password);
        $user->save();
        return response()->json($user, 200);

    }
    
    public function update(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Validación de los datos del request (opcional, pero recomendado)
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'p_venta' => 'nullable|string|max:100',
            'cargo' => 'nullable|string|max:100',
        ]);
    
        // Actualizar solo los campos que están presentes en la solicitud (sin `cedula`)
        $user->update($request->only(['email', 'p_venta', 'cargo']));
    
        // Retornar la respuesta con el usuario actualizado
        return response()->json($user);
    }
    
    
   
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json($user);
    }


    public function sendResetPin(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Buscar el usuario por correo electrónico
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    // Generar un PIN aleatorio
    $pin = rand(100000, 999999);

    // Guardar el PIN en el usuario (puedes crear un campo en la tabla de usuarios)
    $user->reset_pin = bcrypt($pin); // O almacenarlo en otra parte segura
    $user->save();

    // Enviar el PIN por correo
    \Mail::to($user->email)->send(new \App\Mail\ResetPinMail($pin));

    return response()->json(['message' => 'PIN enviado a tu correo']);
}


public function resetPasswordWithPin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'pin' => 'required',
        'new_password' => 'required|min:8',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->pin, $user->reset_pin)) {
        return response()->json(['message' => 'PIN incorrecto o usuario no encontrado'], 401);
    }

    // Actualizar la contraseña
    $user->password = Hash::make($request->new_password);
    $user->reset_pin = null; // Limpiar el PIN después de usarlo
    $user->save();

    return response()->json(['message' => 'Contraseña actualizada con éxito']);
}



    public function activate($id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->is_active = true;
    $user->save();

    // Enviar correo al usuario
    \Mail::to($user->email)->send(new \App\Mail\UserActivated($user));

    return response()->json(['message' => 'User activated successfully']);
}


public function deactivate($id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->is_active = false;
    $user->save();

    // Enviar correo al usuario
    \Mail::to($user->email)->send(new \App\Mail\UserDeactivated($user));

    return response()->json(['message' => 'User deactivated successfully']);
}

}