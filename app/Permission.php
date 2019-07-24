<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['section_id','user_role_id','add','edit','view','delete','read'];
}
