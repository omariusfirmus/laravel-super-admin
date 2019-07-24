<?php

namespace App\Http\Controllers\superAdmin;

use App\Permission;
use App\Section;
use App\SectionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class sectionsController extends Controller
{
    public function viewSection($table) {
        $data = ['section'=>'view'];
        $data['rows'] = DB::table($table)->orderBy('id','desc')->paginate(20);
        $data['cols'] = DB::table($table)->limit(1)->get();
        $data['title'] = str_replace('_',' ',\Illuminate\Support\Str::title(ucfirst($table)));
        $data['table'] = $table;
        return view('super-admin.sections')->with($data);
    }
    public function addSections($table) {
        $section = Section::where('table',$table)->first();
        $data['section'] = 'add';
        $data['title'] = str_replace('_',' ',\Illuminate\Support\Str::title(ucfirst($table)));
        $data['table'] = $table;
        $data['fields'] = SectionDetail::where('section_id',$section->id)->get();
        $sections = '';
        if ($table == 'user_roles')
        {
            $sections = DB::table('sections')->get();
            $data['sections'] = $sections;

        }
        return view('super-admin.sections')->with($data);

    }
    public function storeSections(Request $r, $table) {
        $fields = $r->except('_token') ;

        $section = Section::where('table',$table)->first();
        $column_names = SectionDetail::where('section_id',$section->id)->get();
        $data = [];
        foreach ($column_names as $col)
        {
            $data[$col->field] = $r->input($col->field);
            if (in_array($col->type,['file','image','multiple_images']))
            {

                if ($r->hasFile($col->field) and $col->type != 'multiple_images')
                {
                   $data[$col->field] = $this->uploadFile($r->file($col->field));
                }
                if ($col->type == 'multiple_images')
                {
                    $images = [];

                    foreach ($r->file($col->field) as $image)
                    {
                        $images[] = $this->uploadFile($image);
                    }
                    if (count($images)) $data[$col->field] = json_encode($images);
                }
            }
        }
        $id = DB::table($table)->insertGetId($data);
        if ($id)
        {
            if ($r->has('perms'))
            {
//                dd($r->input('perms'));
                $actions = ['add','edit','view','read','delete'];
                foreach ($r->input('perms') as $sec_name => $perm)
                {
                    $sec=  DB::table('sections')->where('table',$sec_name)->first();
                    foreach ($actions as $act)
                    {

                        if (array_key_exists($act,$r->input('perms')[$sec_name]))
                        {
                            $dtt[$act] = 1;
                        }
                        else
                        {
                            $dtt[$act] = 0;
                        }

                    $dtt['section_id'] = Section::where('table',$sec_name)->first()->id;
                    $dtt['user_role_id'] = $id;

                    }
                    Permission::create($dtt);


                }

            }
            Session::put('message','Item was added successfully');
            return redirect('/super-admin/section/view/'.$table);
        }
        Session::put('message','Something went wrong');
        return redirect()->back();

    }

    public function editSections($table, $id) {
        $section = Section::where('table',$table)->first();
        $data['fields'] = SectionDetail::where('section_id',$section->id)->get();
        $data['section'] = 'edit';
        $data['title'] = str_replace('_',' ',\Illuminate\Support\Str::title(ucfirst($table)));
        $data['table'] = $table;
        $data['row'] = DB::table($table)->where('id',$id)->first();
        $data['row'] = (array) $data['row'];
        $sections = '';
        if ($table == 'user_roles')
        {
            $sections = DB::table('sections')->get();
            $data['sections'] = $sections;
        }
        $data['id'] = $id;
        return view('super-admin.sections')->with($data);

    }
    public function updateSections(Request $r, $table,$id) {
//        dd($r->all());
        $section = Section::where('table',$table)->first();
        $column_names = SectionDetail::where('section_id',$section->id)->get();
        $data = [];
        $row =  DB::table($table)->find($id) ;

        foreach ($column_names as $col)
        {
            $colum = $col->field;

//            $data[$col->field] = $r->input($col->field) ;
            $data[$col->field] =$r->has($col->field) ? $r->input($col->field): $row->$colum;


            if (in_array($col->type,['file','image','multiple_images']))
            {

                if ($r->hasFile($col->field) and $col->type != 'multiple_images')
                {
                    $data[$col->field] = $this->uploadFile($r->file($col->field));
                }
                if ($col->type == 'multiple_images')
                {
                    $data[$col->field] = json_encode($r->input($col->field.'_old'));
                }
                if ($r->file($col->field) && $col->type == 'multiple_images')
                {

                    $old_images =  $r->input($col->field.'_old');

                    foreach ($r->file($col->field) as $image)
                    {
                        $old_images [] = $this->uploadFile($image);
                    }
                    if (count($old_images )) $data[$col->field] = json_encode($old_images );
                }
            }
        }
        $data['id'] = $id;
        unset($data['id']);
        $update = DB::table($table)->where('id',$id)->update($data);
//        dd($update );
        if ($table == 'user_roles')
        {
            if ($row-> role_name == $r->input('role_name') and $row->created_at == $r->input('created_at'))
            {
                $update =1;
            }
        }
//        dd($update);
        if ($update)
        {

                if ($table == 'user_roles')
                {
                    $actions = ['add'=>'0','edit'=>'0','view'=>0,'read'=>0,'delete'=>0];
//                dd($r->input('perms'));

                    foreach ($r->input('perms') as $sec_name => $perm)
                    {

                        $sec=  DB::table('sections')->where('table',$sec_name)->first();
                        $perms = $r->input('perms')[$sec_name];
                        $dtt = $actions;
//                    dd($perms);
                        foreach ($actions as  $kact => $act)
                        {
                            $dtt[$kact] = $perms[$kact];
                            $dtt['section_id'] = Section::where('table',$sec_name)->first()->id;
                            $dtt['user_role_id'] = $id;
                        }
//                    dd($dtt);
                        Permission::where(['section_id'=>$dtt['section_id'], 'user_role_id'=>$dtt['user_role_id']])->update($dtt);
                    }
                }

            Session::put('message','Item was updated successfully');
            return redirect(url('super-admin/section/edit/'.$table.'/'.$id));
        }
        Session::put('message','Nothing was updated');
        return redirect()->back();
    }
    public function deleteSections() {}

    function uploadFile($file) {
        $newName = Str::random(5).$file->getClientOriginalName();
        if ($file->move('uploads',$newName))
            return $newName;

        return null;

    }
}
