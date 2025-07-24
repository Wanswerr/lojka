<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Começa a query
        $query = User::withCount('orders');

        // Se houver um termo de pesquisa, aplica o filtro
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        // Retorna a view com os usuários e o termo de pesquisa
        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create($validatedData);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        if (!empty($validatedData['password'])) {
            $user->password = $validatedData['password'];
        }

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'Cliente excluído com sucesso!');
    }

    public function show(User $user)
    {
        // Carrega os pedidos do usuário
        $user->load(['orders' => function ($query) {
            $query->latest();
        }]);

        // Busca o carrinho abandonado do usuário com seus itens e produtos
        $abandonedCart = $user->cart()->with('items.product')->first();

        // Calcula a receita total gerada
        $totalRevenue = $user->orders()->where('status', 'paid')->sum('total');

        // Passa todas as variáveis necessárias para a view
        return view('admin.users.show', compact('user', 'totalRevenue', 'abandonedCart'));
    }
}