<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UtilizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'price'=>$this->price,
            'size_name'=>$this->size_name,
            'color_code'=>$this->color_code,
            'color_name'=>$this->color_name,
            'active'=>$this->active,
            'status_name'=>$this->status_name,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'notes'=>$this->notes,
            'user'=>AccountResource::make($this->user),
            'category'=>CategoryResource::make($this->category),
            'main_photo'=>$this->main_photo,
            'sub_photos'=>ImageResource::collection($this->sub_photo),
        ];
    }
}
