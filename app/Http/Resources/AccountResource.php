<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'id' =>$this->id,
            'f_name' =>$this->f_name,
            'l_name' =>$this->l_name,
            'username' =>$this->username,
            'phone' =>$this->phone,
            'email' =>$this->email,
            'status' =>$this->status,
            'device_token' =>$this->device_token,
            'photo' =>$this->photo,
            'unread_notifications' => auth()->user()->unreadNotifications->count(),
        ];
    }
}
