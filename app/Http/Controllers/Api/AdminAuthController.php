<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Lida com a tentativa de login do administrador via API.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Encontra o admin pelo email
        $admin = Admin::where('email', $request->email)->first();

        // Verifica se o admin existe e se a senha está correta
        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // Cria um token de API para o guarda 'admin'
        $token = $admin->createToken('admin-token', ['admin'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $admin
        ]);
    }

    /**
     * Retorna os dados do administrador autenticado.
     */
    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * Faz o logout do administrador, revogando o token atual.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}