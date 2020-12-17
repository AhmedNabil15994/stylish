<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserServiceResource extends JsonResource
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
            'description'=>$this->description,
            'user_id'=>$this->user_id,
            'service_id'=>$this->service_id,
            'service_name'=>$this->service->title,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'work_hours'=>$this->work_hours,
            'work_days'=>$this->work_days,
            'price'=>$this->price,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'created_at'=>$this->created_at,
        ];
    }
}
