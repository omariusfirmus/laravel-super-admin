<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['id','_key','_value'];
    public $timestamps = false;
}
