<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function collect;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'seller', 'customer', 'user'];

        collect($roles)->each(function ($role) {
            $exists = DB::table('roles')
                ->where('name', $role)
                ->exists();

            if (! $exists) {
                DB::table('roles')->insert([
                    'name' => $role,
                    'guard_name' => 'web',
                    'created_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        });

        $permissions = [];

        collect($permissions)->each(function ($permission) {
            $exists = DB::table('permissions')
                ->where('name', $permission)
                ->exists();

            if (! $exists) {
                DB::table('permissions')->insert([
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        });

        $users = User::query()->get();

        collect($users)->each(function ($user) {
            $user->assignRole($user['role']);
        });
    }
}
