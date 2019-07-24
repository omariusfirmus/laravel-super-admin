<?php

use Illuminate\Database\Seeder;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data['section_id'] = 1;
        $data['user_role_id'] = 1;
        $data['add'] = 1;
        $data['edit'] = 1;
        $data['view'] = 1;
        $data['read'] = 1;
        $data['delete'] = 1;

        \App\Permission::create($data);



        $data['section_id'] = 1;
        $data['user_role_id'] = 2;
        $data['add'] = 1;
        $data['edit'] = 1;
        $data['view'] = 1;
        $data['read'] = 1;
        $data['delete'] = 0;

        \App\Permission::create($data);

        $data['section_id'] = 2;
        $data['user_role_id'] = 1;
        $data['add'] = 1;
        $data['edit'] = 1;
        $data['view'] = 1;
        $data['read'] = 1;
        $data['delete'] = 1;

        \App\Permission::create($data);


        $data['section_id'] = 2;
        $data['user_role_id'] = 2;
        $data['add'] = 1;
        $data['edit'] = 1;
        $data['view'] = 1;
        $data['read'] = 1;
        $data['delete'] = 0;

        \App\Permission::create($data);

    }
}
