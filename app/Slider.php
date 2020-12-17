<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title'];
    protected $guarded = ['id'];

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

    public function trash()
    {
        $photo = public_path($this->image->url);
        if (is_file($photo))
        {
            @unlink($photo);
            $this->image()->delete();
        }
        $this->deleteTranslations();
        $this->delete();
    }

}
