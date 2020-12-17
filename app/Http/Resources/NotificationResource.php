<?php

namespace App\Http\Resources;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title'=>$this->data['notify'][app()->getLocale()]['title'],
            'is_read'=>$this->read_at ? true : false,
            'created_at'=>Carbon::parse($this->created_at)->isoFormat('dddd, MMMM D, YYYY h:mm A'),
        ];
        if (isset($this->data['notify'][app()->getLocale()]['desc']))
        {
            $data['desc'] = $this->data['notify'][app()->getLocale()]['desc'];
        }
        if (isset($this->data['notify']['photo']))
        {
            $data['photo'] = $this->data['notify']['photo'];
        }
        if (isset($this->data['notify']['order_id']))
        {
            $data['order'] = OrderResource::make(Order::find($this->data['notify']['order_id']));
        }
        return $data;
    }
}
