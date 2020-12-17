<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
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

//    public function parentCat()
//    {
//        return $this->belongsTo($this,'parent')->withDefault();
//    }
//
//    public function subs()
//    {
//        return $this->hasMany($this,'parent');
//    }
//
//    public function getParentNameAttribute()
//    {
//        return $this->parent == 0 ? __('translate.main_category') : $this->parentCat->name;
//    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
