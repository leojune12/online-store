<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $superadmin_user = User::find($superadmin_user_id);
        $superadmin_user->assignRole('superadmin');

        $admin_user = User::find($admin_user_id);
        $admin_user->assignRole('admin');

        User::factory(100)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
