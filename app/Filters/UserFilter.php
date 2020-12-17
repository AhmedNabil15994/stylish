<?php


namespace App\Filters;


class UserFilter extends Filters
{
     protected $var_filters=[
        'name','phone','active'
     ];


    public function name($name)
    {
        return $this->builder->where(function ($q)use ($name){
            $q->where('f_name','like','%'.$name.'%')
                ->orWhere('l_name','like','%'.$name.'%')
                ->orWhereIn('f_name',explode(' ',$name))
                ->orWhereIn('l_name',explode(' ',$name));
        });
     }

    public function phone($phone)
    {
        return $this->builder->where('phone',$phone);
    }

    public function active($active)
    {
        if ($active == 3)
            $active =0;
        return $this->builder->where('status',$active);
    }
}
