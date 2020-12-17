<?php

namespace App;

use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','desc','color_name'];
    protected $guarded = ['id'];

    public function image()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function getMainPhotoAttribute()
    {
        return $this->image()->where('type','main')->first()->full_url ?? asset('assets/admin/images/default-image.png');
    }

    public function getSubPhotoAttribute()
    {
        return $this->image()->where('type','sub')->get();
    }


    public function trash()
    {
        $photo = public_path($this->image()->where('type','=','main')->first()->url);
        $subs = $this->image()->where('type','=','sub')->get();
        if (is_file($photo))
        {
            @unlink($photo);
        }
        foreach ($subs as $sub)
        {
            if (is_file(public_path($sub->url)))
            {
                @unlink(public_path($sub->url));
            }
        }

        $this->image()->delete();
        $this->deleteTranslations();
        $this->delete();
    }


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id')->withDefault();
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withDefault();
    }

    public function scopeActiveProducts($query)
    {
        return $this->where('status',1);
    }

    public function scopeFilter($query,ProductFilter $filter)
    {
        return $filter->apply($query);
    }

    public function getSizeNameAttribute()
    {
        switch ($this->size) {
            case 1:
                $name = 'صغير';
                break;
            case 2:
                $name = 'متوسط';
                break;
            case 3:
                $name = 'لارج';
                break;
            case 4:
                $name = 'اكس لارج';
                break;
            case 5:
                $name = '2 اكس لارج';
                break;
            case 6:
                $name = '3 اكس لارج';
                break;
            default:
                $name = '';
        }
        return $name;
    }
}
