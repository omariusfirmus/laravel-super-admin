<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class sectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data['table']  ='users';
        $data['fields'] = json_encode(DB::getSchemaBuilder()->getColumnListing($data['table']));

        \App\Section::create($data);


        $data['table']  ='user_roles';
        $data['fields'] = json_encode(DB::getSchemaBuilder()->getColumnListing($data['table']));

        \App\Section::create($data);

    }
}
