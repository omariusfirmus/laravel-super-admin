<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //types = text, textarea, editor, image, file, checkbox, dropdown, radio,
        $data = [
            ['_key'=> 'site_title','_value'=>'Site Title','group'=>'site_options','type'=>'text'],
            ['_key'=> 'logo_dark','_value'=>'','group'=>'site_options','type'=>'image'],
            ['_key'=> 'logo_light','_value'=>'','group'=>'site_options','type'=>'image'],
            ['_key'=> 'faveicon','_value'=>'','group'=>'site_options','type'=>'image'],
            ['_key'=> 'meta_description','_value'=>'this is the site description for search engines','group'=>'site_options','type'=>'textarea'],
            ['_key'=> 'footer_copyrights','_value'=>'copyright&copy; '.date('Y'),'group'=>'site_options','type'=>'editor'],
            ['_key'=> 'map','_value'=>'','group'=>'site_options','type'=>'textarea'],
            ['_key'=> 'address','_value'=>'','group'=>'site_options','type'=>'textarea'],
            ['_key'=> 'mobile','_value'=>'','group'=>'site_options','type'=>'text'],
            ['_key'=> 'email','_value'=>'','group'=>'site_options','type'=>'text'],
            ['_key'=> 'messages_email','_value'=>'','group'=>'site_options','type'=>'text'],
            ['_key'=> 'facebook','_value'=>'','group'=>'social','type'=>'text'],
            ['_key'=> 'twitter','_value'=>'','group'=>'social','type'=>'text'],
            ['_key'=> 'google-plus','_value'=>'','group'=>'social','type'=>'text'],
            ['_key'=> 'instagram','_value'=>'','group'=>'social','type'=>'text'],
            ['_key'=> 'youtube','_value'=>'','group'=>'social','type'=>'text'],
            ['_key'=> 'linkedin','_value'=>'','group'=>'social','type'=>'text'],
        ];
        \App\Setting::insert($data);
    }
}