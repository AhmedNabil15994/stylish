<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'name'=>$this->name,
            'address'=>$this->address,
            'phone1'=>$this->phone1,
            'phone2'=>$this->phone2,
            'email1'=>$this->email1,
            'email2'=>$this->email2,
            'android'=>$this->android,
            'ios'=>$this->ios,
            'windows'=>$this->windows,
            'facebook'=>$this->facebook,
            'twitter'=>$this->twitter,
            'youtube'=>$this->youtube,
            'instagram'=>$this->instagram,
            'map'=>$this->map,
            'logo'=>$this->logo,
            'icon'=>$this->icon,
        ];
    }
}
