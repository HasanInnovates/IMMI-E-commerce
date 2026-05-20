<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],
            ['name' => 'Manage Categories', 'slug' => 'manage-categories'],
            ['name' => 'Manage Products', 'slug' => 'manage-products'],
            ['name' => 'Manage Orders', 'slug' => 'manage-orders'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions'],
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'View Reports', 'slug' => 'view-reports'],
        ];

        $savedPermissions = [];
        foreach ($permissions as $p) {
            $savedPermissions[$p['slug']] = Permission::firstOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }

        $roles = [
            'super-admin' => [
                'name' => 'Super Admin',
                'permissions' => ['view-dashboard', 'manage-categories', 'manage-products', 'manage-orders', 'manage-roles', 'manage-permissions', 'manage-users', 'view-reports'],
            ],
            'admin' => [
                'name' => 'Admin',
                'permissions' => ['view-dashboard', 'manage-categories', 'manage-products', 'manage-orders'],
            ],
            'customer' => [
                'name' => 'Customer',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = Role::firstOrCreate(
                ['slug' => $slug],
                ['name' => $data['name'], 'description' => $data['name'] . ' role']
            );

            $permSlugs = $data['permissions'];
            $role->permissions()->sync(
                array_map(fn($s) => $savedPermissions[$s]->id, $permSlugs)
            );
        }

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        $superAdminUser = User::where('email', 'admin@example.com')->first();
        if ($superAdminUser) {
            $superAdminUser->roles()->syncWithoutDetaching([$superAdminRole->id, $adminRole->id]);
        }

        $customerUser = User::where('email', 'customer@example.com')->first();
        if ($customerUser) {
            $customerUser->roles()->syncWithoutDetaching([$customerRole->id]);
        }
    }
}
