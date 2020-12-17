<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent_name'=>$this->parent_name,
            'name'=>$this->name,
            'photo'=>$this->photo,
//            'products'=>$this->products()->paginate(5),
        ];
    }
}
