<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','address','phone1','phone2'];
    protected $guarded = ['id'];

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'url'=>'assets/admin/images/default-image.png'
        ]);
    }
    public function getLogoAttribute()
    {
        return $this->image()->where('type','logo')->first()->full_url ?? null;
    }

    public function getIconAttribute()
    {
        return $this->image()->where('type','icon')->first()->full_url ?? null;
    }

    public function trash()
    {
        $logo = public_path($this->image()->where('type','logo')->first()->url);
        $icon = public_path($this->image()->where('type','icon')->first()->url);
        if (is_file($logo))
        {
            @unlink($logo);
        }
        if (is_file($icon))
        {
            @unlink($icon);
        }
        $this->image()->delete();
        $this->deleteTranslations();
        $this->delete();
    }
}
