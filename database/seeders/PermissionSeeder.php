<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permission sesuai yang dipakai di routes dan sidebar
        $permissions = [
            'pengaturan',
            'import_data',
            'web_service',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['uuid' => Str::uuid()]
            );
        }

        // Buat role admin dengan semua permission
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['uuid' => Str::uuid()]
        );
        $adminRole->givePermissionTo($permissions);

        // Buat role operator dengan permission terbatas
        $operatorRole = Role::firstOrCreate(
            ['name' => 'operator', 'guard_name' => 'web'],
            ['uuid' => Str::uuid()]
        );
        $operatorRole->givePermissionTo(['import_data', 'web_service']);

        // Assign role admin ke user pertama (admin@gmail.com) jika sudah ada
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser && $adminUser->roles->isEmpty()) {
            $adminUser->assignRole('admin');
        }
    }
}
