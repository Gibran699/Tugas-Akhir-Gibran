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
        // Daftar permission sesuai yang dipakai di routes dan sidebar
        $permissionNames = [
            'pengaturan',
            'import_data',
            'web_service',
        ];

        // Buat permissions dan simpan objeknya langsung
        $permissionObjects = [];
        foreach ($permissionNames as $name) {
            $permissionObjects[] = Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['uuid' => Str::uuid()]
            );
        }

        // Reset cache SETELAH buat permissions agar sinkron
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat role admin, assign via objek (bukan string) — bypass findByName cache
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['uuid' => Str::uuid()]
        );
        $adminRole->syncPermissions($permissionObjects);

        // Buat role operator: hanya bisa lihat data, tanpa permission khusus
        Role::firstOrCreate(
            ['name' => 'operator', 'guard_name' => 'web'],
            ['uuid' => Str::uuid()]
        );

        // Assign role admin ke user pertama (admin@gmail.com) jika sudah ada
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser && $adminUser->roles->isEmpty()) {
            $adminUser->assignRole('admin');
        }
    }
}
