<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title','desc'];
    protected $guarded = ['id'];
    protected $dates = ['created_at'];

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'url'=>'assets/admin/images/default-image.png'
        ]);
    }

    public function getPhotoAttribute()
    {
        return $this->image->full_url;
    }
}
