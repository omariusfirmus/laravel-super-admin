<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 7/10/2019
 * Time: 1:15 PM
 */

namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Helpers
{
    static function shortcode ($string) {
        if (is_string($string) && $string != '')
        {   if (/*has more than one setting: separated by <>*/ Str::contains($string,'<>'))
            {
                $strs = explode('<>',$string);
                $string = self::processPhrase($strs);
            }
            else
            {
                $string = self::processPhrase($string);
            }
        }

        return $string;
    }

    static function processPhrase($string) {
        if (is_array($string))
        {
            // 1. fetching categories with selected item ie: [table=categories]<>[selected=3]
            $all = [];
                foreach ($string as $str)
                {
                    $all[] = self::shortCodeStringToArray($str);
                }
                $query = DB::table($all[0][1])->orderBy('id','asc')->get();
                ob_start();
                foreach ($query as $row)
                {
                    if ($all[0][1] == 'user_roles')
                    { ?>
                        <option <?= $row->role_name == $all[1][1] ? 'selected':'' ?> value="<?= $row->role_name ?>"><?= $row->role_name ?></option>
                    <?php }
                    else {
                    ?>
                        <option <?= $row->id == $all[1][1] ? 'selected':'' ?> value="<?= $row->id ?>"><?= $row->title ?></option>
                    <?php }
                }
                $result = ob_get_clean();


//            dd($all);
            return $result;
            //            dd($string);
        }

        $string = self::shortCodeStringToArray($string);
//        [table=something]
//        dd($string);
        if ($string[0] == 'table')
        {

            $rows = DB::table(end($string))->orderBy('id','asc')->get();
            ob_start();
            foreach ($rows as $row)
            {
                switch($string[1])
                {
                    case 'users':
                        $title = $row->name;
                        break;
                    case 'user_roles':
                        $title = $row->role_name;
                        break;
                    default:
                        $title = $row->title;
                        break;
                }
                ?>
                <option value="<?= $row->id ?>"><?= $title ?></option>
                <?php
            }
            $result = ob_get_clean();

            return $result;
        }
        //        [labels=a,b,c,d]
        elseif ($string[0] == 'labels') {
            $values = end($string);
            $values = explode(',',$values);
            return $values;
        }
        //[default=something]
        elseif ($string[0] == 'default')
        {
            $value = end($string);
            return $value;
        }
        //[type=slug]
        elseif ($string[0] == 'type')
        {
            if ($string[1] == 'slug')
            ob_start();
            ?>
            <script>
                function convertToSlug(Text)
                {
                    return Text
                        .toLowerCase()
                        .replace(/[^\w ]+/g,'')
                        .replace(/ +/g,'-')
                        ;
                }
                document.querySelector('input[name=title]').addEventListener ('keyup',function () {
                    document.querySelector('input[name=slug]').value = convertToSlug(document.querySelector('input[name=title]').value);
                });
            </script>
            <?php
            $value = ob_get_clean();
            return $value;
        }
        return $string;
    }

    static function shortCodeStringToArray ($str) {
        $str = str_replace('[','',$str);
        $str = str_replace(']','',$str);
        $str = explode ('=',$str);
        return $str;
    }
    static function uploadFile($file) {
        $newName = Str::random(5).$file->getClientOriginalName();
        if ($file->move('uploads',$newName))
            return $newName;

        return null;
    }
}