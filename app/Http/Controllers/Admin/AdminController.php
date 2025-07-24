<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todos os admins, carregando seus papéis (roles) junto
        $admins = Admin::with('roles')->latest()->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Busca todos os papéis para listá-los no formulário
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array'
        ]);

        // 2. Cria o administrador
        $admin = Admin::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // 3. Atribui os papéis selecionados ao novo admin
        $admin->assignRole($validatedData['roles']);

        // 4. Redireciona com mensagem de sucesso
        return redirect()->route('admin.admins.index')
                        ->with('success', 'Administrador criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        // 1. Validação
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array'
        ]);

        // 2. Atualiza os dados principais
        $admin->name = $validatedData['name'];
        $admin->email = $validatedData['email'];

        // 3. Atualiza a senha APENAS se uma nova for fornecida
        if (!empty($validatedData['password'])) {
            $admin->password = Hash::make($validatedData['password']);
        }

        $admin->save();

        // 4. Sincroniza os papéis, garantindo que o Super Admin não perca seu papel.
        if ($admin->id === 1) {
            $admin->assignRole('Super Admin');
        } else {
            $admin->syncRoles($validatedData['roles']);
        }

        return redirect()->route('admin.admins.index')
                        ->with('success', 'Administrador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
        {
            // Trava 1: Não permite excluir o Super Admin principal (ID 1)
            if ($admin->id === 1) {
                return redirect()->route('admin.admins.index')
                                ->with('error', 'O Super Administrador principal não pode ser excluído.');
            }

            // Trava 2: Não permite que um admin se auto-exclua
            if (auth('admin')->user()->id === $admin->id) {
                return redirect()->route('admin.admins.index')
                                ->with('error', 'Você não pode excluir sua própria conta.');
            }

            $admin->delete();

            return redirect()->route('admin.admins.index')
                            ->with('success', 'Administrador excluído com sucesso!');
    }
}
