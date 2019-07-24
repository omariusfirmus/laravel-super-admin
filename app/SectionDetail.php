<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionDetail extends Model
{
    protected $fillable = ['section_id','field','type','display_name','optional_details'];
}
