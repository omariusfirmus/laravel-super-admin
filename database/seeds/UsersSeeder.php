<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = "Admin";
        $user->username = "Admin";
        $user->email = "omarius15@gmail.com";
        $user->password = Hash::make('admin@admin.com');
        $user->user_role = "super-admin";
        $user->save();
        $user = new \App\User();
        $user->name = "Velox User";
        $user->username = "velox";
        $user->email = "velox@admin.com";
        $user->password = Hash::make('velox@admin.com');
        $user->user_role = "admin";
        $user->save();
    }
}
