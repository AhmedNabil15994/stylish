<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWorkResource extends JsonResource
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
            'description'=>$this->description,
            'user_id'=>$this->user_id,
            'user_name'=>$this->user->f_name.' '.$this->user->l_name,
            'created_at'=>$this->created_at,
            'photo'=>$this->photo,
        ];
    }
}
