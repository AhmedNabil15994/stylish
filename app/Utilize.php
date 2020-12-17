<?php

namespace App;

use App\Filters\UtilizeFilter;
use Illuminate\Database\Eloquent\Model;

class Utilize extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function image()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function getMainPhotoAttribute()
    {
        return $this->image()->where('type','main')->first()->full_url ?? null;
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
        $this->delete();
    }


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id')->withDefault();
    }

    public function scopeActiveUtilizes($query)
    {
        return $this->where('active',1);
    }

    public function scopeFilter($query,UtilizeFilter $filter)
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

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 1:
                $name = 'سبئ';
                break;
            case 2:
                $name = 'جيد';
                break;
            case 3:
                $name = 'ممتاز';
                break;
            default:
                $name = '';
        }
        return $name;
    }

    public function getActiveNameAttribute()
    {
        switch ($this->active) {
            case 1:
                $name = 'مفعل';
                break;
            case 0:
                $name = 'غير مفعل';
                break;
            default:
                $name = '';
        }
        return $name;
    }
}
