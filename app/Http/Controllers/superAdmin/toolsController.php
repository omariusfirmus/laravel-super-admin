<?php

namespace App\Http\Controllers\superAdmin;
use App\Http\Controllers\Controller;
use App\Section;
use App\SectionDetail;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;

class toolsController extends Controller
{

    function _constructor () {
        if (Auth::user()->username !='Admins')
        {
            return redirect()->back();
        }
    }
    function databaseView () {
        $tables = DB::select('SHOW TABLES');
        $data['tables'] = $tables;
        
        return view('super-admin.tools.database-view')->with($data);
    }
    function databaseAdd() {

        return view('super-admin.tools.database-add');
    }

    function databaseStore(Request $r) {

        if (Schema::hasTable($r->table_name))
        return redirect()->back()->with(['message'=>'Table already exists']);

        if ($r->create_model)
        Artisan::call('make:model '.Str::singular(ucfirst($r->table_name)));
        Schema::create($r->table_name, function(Blueprint $table) use ($r) {
            $i = 0;

            foreach ($r->input('name') as $col_name)
            {

                if ($col_name == '') continue;
                switch ($r->type[$i]) {
                    case 'integer':

                        if (array_search($i, $r->increment))
                            $tbl = $table->increments($col_name);
                        else
                            $tbl = $table->integer($col_name);
                    break;
                    case 'biginteger':
                        if (@$r->increment[$i])
                            $tbl = $table->bigIncrements($col_name);
                        else
                            $tbl = $table->bigInteger($col_name);
                    break;

                    case 'varchar':
                        $tbl = $table->string($col_name);
                    break;

                    case 'text':
                        $tbl = $table->text($col_name);
                    break;
                    case 'float':
                        $tbl = $table->float($col_name);
                    break;
                    case 'decimal':
                        $tbl = $table->decimal($col_name);
                    break;
                    case 'datetime':
                        $tbl = $table->timestamp($col_name);
                    break;
                }
                if ($tbl->nullable[$i])
                     $tbl = $tbl->nullable();
                // dd($r->index[$i]);
                switch ($r->index[$i])
                {
                    case 'unique':
                        $tbl = $tbl->unique($col_name);
                    break;
//                    case 'primary':
//                    $tbl = $tbl->primary($col_name);
                    break;
                    case 'index':
                        $tbl = $tbl->index($col_name);
                    break;
                }
                if ($r->default[$i] !='')
                {
                    $tbl = $tbl->default($r->default[$i]);
                }

                $i++;
            }
            $table->timestamps();

        });
        Session::put('message', 'Table created successfully');
        return Redirect::back();
    }
    function databaseDelete (Request $r, $name) {
        Schema::dropIfExists($name);
        Session::put('message', 'Table Deleted');
        return Redirect::back();
    }
    function databaseEdit(Request $r, $name) {
        $data['table'] = DB::select('DESCRIBE '.$name);
        $data['name' ] = $name;
        $s=0;
        //show saved table columns
        foreach($data['table'] as $col)
        {
            $data['table'][$s]->Type = explode('(',$col->Type)[0];
            $s++;
        }

         return view('super-admin.tools.database-edit')->with($data);
    }
    function databaseUpdate( Request $r  ) {
        Schema::table($r->table_name, function(Blueprint $table) use ($r) {
            $i = 0;
            $if_sec = Section::where('table',$r->table_name);
            if ($if_sec->count())
            {
                $section = $if_sec->first();
                $sec_details = SectionDetail::where('section_id',$section->id);
                if (count($r->new_name) > $sec_details->count() )
                {
                    $sec_details = $sec_details->get();
                    foreach ($r->new_name as $key => $col_name)
                    {
                        if ($col_name == '') continue;
                        $check_existence = SectionDetail::where('field',$col_name)->where('section_id',$section->id)->count();

                        if (!$check_existence)
                        {
//                            dd($r->new_name);
                            $secdata['field'] = $col_name;
                            $secdata['section_id'] = $section->id;
                            $secdata['type'] = 'text';
                            $secdata['display_name'] = ucfirst($col_name);

                            $new = SectionDetail::create($secdata);

                        }
                    }
                }

            }

            foreach ($r->new_name as $key => $col_name)
            {
                if ($col_name == '') continue;


                switch ($r->new_type[$i]) {
                    case 'integer':

                        if (array_search($i, $r->new_increment))
                            $tbl = $table->increments($col_name);
                        else
                            $tbl = $table->integer($col_name);
                    break;
                    case 'biginteger':
                        if (@$r->increment[$i])
                            $tbl = $table->bigIncrements($col_name);
                        else
                            $tbl = $table->bigInteger($col_name);
                    break;

                    case 'varchar':
                        $tbl = $table->string($col_name);
                    break;

                    case 'text':
                        $tbl = $table->text($col_name);
                    break;
                    case 'float':
                        $tbl = $table->float($col_name);
                    break;
                    case 'decimal':
                        $tbl = $table->decimal($col_name);
                    break;
                    case 'timestamp':
                        $tbl = $table->datetime($col_name);
                    break;
                }

                if ($r->new_nullable[$i])
                     $tbl = $tbl->nullable();
                // dd($r->index[$i]);

                switch ($r->new_index[$i])
                {
                    case 'unique':
                        $tbl = $tbl->unique($col_name);
                    break;
                    case 'primary':
                    $tbl = $tbl->primary($col_name);
                    break;
                    case 'index':
                        $tbl = $tbl->index($col_name);
                    break;
                }
                if ($r->default[$i] !='')
                {
                    $tbl = $tbl->default($r->new_default[$i]);
                }

                $i++;

            }


            // itterate through (old_values) and check for changes
            foreach($r->input('old_name') as $key => $col)
            {


                if ($col == '') continue;
                $nullable_txt = $r->nullable[$key] ? " NULL ":" NOT NULL ";
                $increment_txt = $r->increment[$key] ? " AUTO_INCREMENT ":"  ";

                if ($r->index[$key] == 'primary')
                {
                    $columns =  DB::select('DESCRIBE '.$r->table_name);
                    $primary_key_exists = false;
                    foreach ($columns as $column)
                    {
                        if ($column->Key == 'PRI')
                        $primary_key_exists = true;
                    }
                    if (!$primary_key_exists)
                    {
                        $index_txt = 'ALTER TABLE `'.$r->table_name.'` ADD PRIMARY KEY(`'.$col.'`);';
                        DB::statement($index_txt);
                    }

                }
                elseif ($r->index[$key] == 'unique')
                {
                    $index_txt = 'ALTER TABLE `'.$r->table_name.'` ADD UNIQUE(`'.$col.'`);';
                    DB::statement($index_txt);
                }
                elseif ($r->index[$key] == 'index')
                {
                    $index_txt = 'ALTER TABLE `'.$r->table_name.'` ADD INDEX(`'.$col.'`);';
                    DB::statement($index_txt);
                }
                switch ($r->type[$key]) {
                    case 'integer':
                        if ($r->increment != null && @$r->increment[$key])
                        DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` int(11) '.$increment_txt.$nullable_txt);
                        else
                        DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` int(11)'.$nullable_txt);
                    break;
                    case 'biginteger':
                        if ($r->increment != null && @$r->increment[$key])
                        DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` bigint(255) '.$increment_txt.$nullable_txt);
                        else
                        DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` bigint(255)'.$nullable_txt);
                        break;
                    case 'varchar':
                     DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` VARCHAR(255)'.$nullable_txt);
                    break;

                    case 'text':
                    DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` TEXT(10000)'.$nullable_txt);
                      break;
                    case 'float':
                    DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` Float(11)'.$increment_txt.$nullable_txt);
                    break;
                    case 'decimal':
                    DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` DECIMAL(22)'.$increment_txt.$nullable_txt);
                    break;
                    case 'datetime':
                    DB::statement('ALTER TABLE `'.$r->table_name.'` MODIFY COLUMN   `'.$r->old_name[$key] . '` datetime(6)'.$nullable_txt.' ');
                    break;
                }
                // dd($r->nullable);
                // $ch = $r->nullable[$key] == "1" ? $table->string($r->name[$key])->nullable()->change():$table->string($r->name[$key])->nullable(false)->change();
                // if ($r->nullable[$key])
                //      $tbl = $tbl->nullable() ;
                    //  $ch = $r->nullable[$key] ? $table->string($r->nullable[$key])->nullable()->change():'';
                // switch ($r->index[$key])
                // {
                //     case 'unique':
                //         $tbl = $tbl->unique();
                //     break;
                //     case 'primary':
                //         $table->primary($col);
                //     break;
                // }
                // if ($r->default[$key] !='')
                // {
                //     $tbl = $tbl->default($r->default[$key]);
                // }
                 if ($col != $r->old_name[$key]);
                {
                    $table->renameColumn($r->old_name[$key],$r->name[$key])->change();
                }

                $i ++;
            }
        });
            Session::put('message', 'Table Modified successfully');
            return   redirect()->back();;

    }
}
