<?php

namespace App;

use App\Filters\OrderFilter;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'size','color_code','color_name','test_date','notes','type','status','user_id','product_id'
    ];

    protected $dates=['test_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasOne(OrderDetail::class)->withDefault();
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function getMainPhotoAttribute()
    {
        return $this->images()->where('type','main')->first()->full_url ?? null;
    }

    public function getSubPhotoAttribute()
    {
        return $this->images()->where('type','sub')->get();
    }

    public function trash()
    {
        $this->delete();
    }

    public function scopeFilter($query,OrderFilter $filter)
    {
        return $filter->apply($query);
    }


    public function getTypeNameAttribute()
    {
        return $this->type == 0 ? __('translate.ready') : __('translate.tafseal');
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
            case -1:
                $name = 'الغاء';
                break;
            case 0:
                $name = 'انتظار';
                break;
            case 1:
                $name = 'تحضير';
                break;
            case 2:
                $name = 'تسليم';
                break;
            default:
                $name = '';
        }
        return $name;
    }
}
