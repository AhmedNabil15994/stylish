<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = ['id'];
}
