<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Mostra o formulário de login para o admin.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Processa a tentativa de login do admin.
     */
    public function login(Request $request)
    {
        // 1. Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
            // log admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // --- ADICIONE A LÓGICA DE LOG AQUI ---
            AdminAccessLog::create([
                'admin_id' => Auth::guard('admin')->id(),
                'ip_address' => $request->ip(),
                'action' => 'login',
            ]);
            // --- FIM DA LÓGICA DE LOG ---

            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Tentativa de autenticação usando o guarda 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redireciona para o dashboard do admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Se a autenticação falhar
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Faz o logout do admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}