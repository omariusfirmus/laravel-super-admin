<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            $this->call(userRolesSeeder::class);
            $this->call(UsersSeeder::class);
            $this->call(sectionsSeeder::class);
            $this->call(permissionsSeeder::class);
            $this->call(SectionDetailsSeeder::class);
            $this->call(SettingsSeeder::class);


    }
}
