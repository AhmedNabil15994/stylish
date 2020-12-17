<?php


namespace App\Filters;


class OrderFilter extends Filters
{
     protected $var_filters=['order_status','username','type','user_phone'];

    public function order_status($order_status)
    {
        if($order_status == 3)
            $order_status=0;
        return $this->builder->where('status',$order_status);
    }

    public function type($type)
    {
        if($type == 3)
            $type=0;
        return $this->builder->where('type',$type);
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
