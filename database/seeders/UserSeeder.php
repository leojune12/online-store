<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Str;
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
            'name' => 'Superadmin',
            'email' => 'jfljfb@gmail.com',
            'password' => bcrypt('pw@12345'),
        ]);

        Shop::create([
            'user_id' => $superadmin_user_id,
            'slug' => Str::slug('Superadmin'),
            'name' => 'Superadmin',
            'description' => '',
        ]);

        $admin_user_id = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'leojunebedeo@gmail.com',
            'password' => bcrypt('pw@12345'),
        ]);

        Shop::create([
            'user_id' => $admin_user_id,
            'slug' => Str::slug('Admin'),
            'name' => 'Admin',
            'description' => '',
        ]);

        $superadmin_user = User::find($superadmin_user_id);
        $superadmin_user->assignRole('Superadmin');

        $admin_user = User::find($admin_user_id);
        $admin_user->assignRole('Admin');

        User::factory(20)->create()->each(function ($user) {

            $user->assignRole('User');
        });
    }
}
