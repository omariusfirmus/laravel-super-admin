<?php

use Illuminate\Database\Seeder;

class SectionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'users';
        $fields = DB::select('DESCRIBE '.$table);
        $types = [
            'hidden','text','text','text','hidden','hidden','hidden','datetime','hidden','select'
        ];
        $displays = [
            '','Full Name','Username','E-mail','','','','Created At','','User Role'
        ];

        $options = [
            '','','','','','','','','','[table=user_roles]'
        ];
        foreach ($fields as $key => $field)
        {
            $data = [];
            $data['field'] = $field->Field;
            $data['type'] = $types[$key];
            $data['display_name'] = $displays[$key];
            $data['optional_details'] = $options[$key];
            $data['section_id'] = 1;
            \App\SectionDetail::create($data);
        }

        $table = 'user_roles';
        $fields = DB::select('DESCRIBE '.$table);
        $types = [
            'hidden','text','datetime','hidden'
        ];
        $displays = [
            'id','Role Name','Created At','Updated At'
        ];

        $options = [
            '','','','',
        ];
        foreach ($fields as $key => $field)
        {
            $data = [];
            $data['field'] = $field->Field;
            $data['type'] = $types[$key];
            $data['display_name'] = $displays[$key];
            $data['optional_details'] = $options[$key];
            $data['section_id'] = 2;
            \App\SectionDetail::create($data);
        }
    }
}
