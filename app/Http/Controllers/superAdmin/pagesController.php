<?php

namespace App\Http\Controllers\superAdmin;

use App\Helpers;
use App\Permission;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class pagesController extends Controller
{
    function _constructor () {}

    function managePages($type) {
        return view('super-admin.dashboard')->with(['type'=>$type]);
    }

    function postLogin(Request $r) {
        $validate = Validator::make($r->all(),[
            'username' => 'required',
            'password' => 'required|min:8',
        ]);
            if ($validate->fails())
        return redirect()->back()->withErrors($validate);

        $credentials = ['username'=>$r->input('username'),'password'=>$r->input('password')];
        if (Auth::attempt($credentials) ) {
            // Authentication passed...
            return redirect()->intended('super-admin');
        }
        else {

            $validate->getMessageBag()->add('password',"wrong username or password");
             return redirect()->back()->withErrors($validate);

        }

    }

    function saveSettings (Request $r) {
        $fields  = $r->except('_token');
//        $fields = Setting::all();
        foreach ($fields as $key => $field)
        {
            if ($r->hasFile($key))
            {
                $data['_value'] = Helpers::uploadFile( $r->file($key));
                Setting::where('_key' , $key)->update(['_value'=>$data['_value']]);
                continue;
            }
            $type = Setting::where('_key', $key)->first();
            $type = $type->type;
                switch ($type)
                {
                    //types = text, textarea, editor, image, file, checkbox, dropdown, radio,
                    case "text":
                        $data[$key] = $r->input($key);
                        break;
                    case "textarea":
                        $data[$key] = $r->input($key);
                        break;
                    case "editor":
                        $data[$key] = $r->input($key);
                        break;
                    case "checkbox":
                        $data[$key] = $r->input($key) != 1 ? 0:1;
                        break;
                    case "dropdown":
                        $data[$key] = $r->input($key);
                        break;
                    case "radio":
                        $data[$key] = $r->input($key);
                        break;
//                    case "file":
//                        $data[$key] = Helpers::uploadFile( $r->file($key));
//                        break;
//                    case "image":
//                        $data[$key] = Helpers::uploadFile( $r->file($key));
//                        break;
                }

            if ($data[$key] != null)
            Setting::where('_key',$key)->update(['_value'=>$data[$key]]);

        }

        Session::put('message','Settings Updated Successfully');
        return redirect()->back();
    }
    function addSettings (Request $r) {
        $setting = new Setting();
        $setting->_key = $r->input('_key');
        $setting->type = $r->input('type');
        $setting->group = $r->input('group');
        $setting->additional_info= $r->input('additional_info');
        $setting->save();
        return redirect()->back();
    }

    function editProfile () {

    }
    function logout () {
        Auth::logout();
        return redirect('super-admin/login');
    }
    function updateProfile (Request $r) {
        $data['name'] = $r->name;
        $data['username'] = $r->username;
        $data['email'] = $r->email;

        User::where('id',Auth::user()->id)->update($data);
        Session::put('message','User was updated successfully');
        return redirect()->back();
    }
    function  changePassword (Request $r) {
        $rules = [
            'old_pass'             =>  'required',
            'new_pass'     =>  'required',
            'conf_new_pass'   =>  'required|same:new_pass',
        ];
        $credentials = $r->only(
            'old_pass', 'new_pass', 'conf_new_pass'
        );
    }
}
