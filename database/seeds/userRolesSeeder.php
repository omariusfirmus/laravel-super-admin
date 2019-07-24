<?php

use Illuminate\Database\Seeder;

class userRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data['role_name'] = "super-admin";
        \App\UserRole::create($data);

        $data['role_name'] = "admin";
        \App\UserRole::create($data);

    }
}
