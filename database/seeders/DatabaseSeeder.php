<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superadmin_user_id = DB::table('users')->insertGetId([
            'name' => 'superadmin',
            'email' => 'jfljfb@gmail.com',
            'password' => bcrypt('pw@12345'),
        ]);

        $admin_user_id = DB::table('users')->insertGetId([
            'name' => 'admin',
            'email' => 'leojunebedeo@gmail.com',
            'password' => bcrypt('pw@12345'),
        ]);

        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'seller']);
        Role::create(['name' => 'buyer']);

        $superadmin_user = User::find($superadmin_user_id);
        $superadmin_user->assignRole('superadmin');

        $admin_user = User::find($admin_user_id);
        $admin_user->assignRole('admin');

        \App\Models\User::factory(100)->create();
    }
}
