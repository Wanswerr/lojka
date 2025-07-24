<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpa o cache de papéis e permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Lista de permissões
        $permissions = [
            'admin_management',
            'user_management',
            'product_management',
            'order_management',
            'settings_management',
            'view_reports',
        ];

        // Cria as Permissões para o guarda 'admin'
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Cria o Papel "Super Admin" para o guarda 'admin'
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        // Atribui todas as permissões (que agora são do guarda 'admin')
        $superAdminRole->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        // Cria o Papel "Gerente" para o guarda 'admin'
        $managerRole = Role::create(['name' => 'Gerente', 'guard_name' => 'admin']);
        $managerRole->givePermissionTo([
            'product_management',
            'order_management',
            'view_reports'
        ]);

        // Cria o usuário Super Admin (ele já sabe que é do guarda 'admin' por causa do Model)
        $superAdminUser = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@ecommerce.com',
            'password' => 'password' // Lembre-se que o hash é automático
        ]);

        // Atribui o papel 'Super Admin'
        $superAdminUser->assignRole($superAdminRole);
        
        // Cria um usuário de exemplo para o papel de Gerente
        $managerUser = Admin::create([
            'name' => 'Gerente Loja',
            'email' => 'gerente@ecommerce.com',
            'password' => 'password'
        ]);
        
        $managerUser->assignRole($managerRole);
    }
}