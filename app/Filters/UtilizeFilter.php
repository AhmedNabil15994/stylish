<?php


namespace App\Filters;


class UtilizeFilter extends Filters
{
     protected $var_filters=[
         'category_id','name','color_code','address_id','size','price_from','price_to',
         'status','lat','lng','utilize_status','username','user_phone','active'
     ];

    public function category_id($category_id)
    {
        return $this->builder->where('category_id',$category_id);
     }

    public function name($name)
    {
        return $this->builder->where('name','like','%'.$name.'%');
     }

    public function color_code($color_code)
    {
        return $this->builder->where('color_code',$color_code);
     }

    public function address_id($address_id)
    {
        return $this->builder->where('address_id',$address_id);
     }

    public function size($size)
    {
        return $this->builder->where('size',$size);
     }

    public function price_from($price_from)
    {
        return $this->builder->where('price','>=',$price_from);
     }

    public function price_to($price_to)
    {
        return $this->builder->where('price','<=',$price_to);
     }

    public function status($status)
    {
        return $this->builder->where('status',$status);
    }

    public function utilize_status($utilize_status)
    {
        return $this->builder->where('status',$utilize_status);
    }
    public function active($active)
    {
        if($active == 3)
            $active=0;
        return $this->builder->where('active',$active);
    }

    public function lat($lat)
    {
        return $this->builder->where('lat',$lat);
    }

    public function lng($lng)
    {
        return $this->builder->where('lng',$lng);
    }

    public function username($username)
    {
        return $this->builder->whereHas('user',function ($q)use ($username){
            $q->where('f_name','like','%'.$username.'%')
                ->orWhere('l_name','like','%'.$username.'%')
                ->orWhereIn('f_name',explode(' ',$username))
                ->orWhereIn('l_name',explode(' ',$username));
        });
    }

    public function user_phone($user_phone)
    {
        return $this->builder->whereHas('user',function ($q)use ($user_phone){
            $q->where('phone',$user_phone);
        });
    }
}
