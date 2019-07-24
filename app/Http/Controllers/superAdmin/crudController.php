<?php

namespace App\Http\Controllers\superAdmin;

use App\Permission;
use App\Section;
use App\SectionDetail;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class crudController extends Controller
{
    function addCrud($table) {
        $data['table_name']=$table;
        $data['cols'] = DB::select('DESCRIBE '.$table);
        return view('super-admin.tools.crud-add')->with($data);
    }

    function storeCrud(Request $r, $table) {

        $section = Section::create([
            'fields'=> json_encode($r->field),
            'table' => $table
        ]);

        foreach ($r->field as $key => $field)
        {
            $data = [];
            $data['field'] = $field;
            $data['type'] = $r->type[$key];
            $data['display_name'] = $r->display_name[$key];
            $data['optional_details'] = $r->optional_details[$key];
            $data['section_id'] = $section->id;
            SectionDetail::create($data);
        }
        $user_roles = UserRole::all();
        foreach ($user_roles as $role)
        {
            if (!in_array($role->role_name,['super-admin','admin']))
            $data = [];
            $data['section_id'] = $section->id;
            $data['user_role_id'] = $role->id;
            $data['add'] = 1;
            $data['edit'] = 1;
            $data['view'] = 1;
            $data['delete'] = 1;
            $data['read'] = 1;
            Permission::create($data);
        }
        Session::put('message','section added successfully');
        return redirect('/super-admin/database/view');

    }

    function editCrud($table) {
        $data['table_name']=$table;
        $data['cols'] = DB::select('DESCRIBE '.$table);
        $data['section'] = Section::where('table',$table)->first();
        $data['details'] = DB::table('section_details')->where('section_id',$data['section']->id)->get();

        return view('super-admin.tools.crud-edit')->with($data);
    }

    function updateCrud(Request $r, $table) {

        Section::where('table' , $table)->update([
            'fields'=> json_encode($r->field)
        ]);
        $section = Section::where('table',$table)->first();

        foreach ($r->field as $key => $field)
        {

            $data = [];
            $data['type'] = $r->input('type')[$key];
            $data['display_name'] = $r->input('display_name')[$key];
            $data['optional_details'] = $r->input('optional_details')[$key];
            SectionDetail::where([
                'section_id'=>$section->id,
                'field' =>$field
            ])->update($data);
        }
        Session::put('message','section Edited successfully');
        return redirect()->back();
//        return redirect('/super-admin/database/view');

    }

    function deleteCrud() {}
}
