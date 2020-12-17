<?php


namespace App\Filters;


class ProductFilter extends Filters
{
     protected $var_filters=['category_id','name','color_code','address_id','size','price_from','price_to'];

    public function category_id($category_id)
    {
        return $this->builder->where('category_id',$category_id);
     }

    public function name($name)
    {
        return $this->builder->whereTranslationLike('name','%'.$name.'%');
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
}
