<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Favorite;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'=>$this->id,
            'name'=>$this->name,
            'desc'=>$this->desc,
            'color_name'=>$this->color_name,
            'color_code'=>$this->color_code,
            'price'=>$this->price,
            'size_name'=>$this->size,
            'category'=>CategoryResource::make($this->category),
            'address'=>AddressResource::make($this->address),
            'likes'=> Favorite::where('product_id',$this->id)->count(),
            'main_photo'=>$this->main_photo,
            'sub_photos'=>ImageResource::collection($this->sub_photo),
        ];
        if (auth()->check())
        {
            $data['favorite'] = auth()->user()->favorites()->where('product_id',$this->id)->first() ? true : false;
        }
        return $data;
    }
}
