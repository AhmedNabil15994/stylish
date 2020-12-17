<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'product'=>ProductResource::make($this->product),
            'size'=>$this->size,
            'color_code'=>$this->color_code,
            'color_name'=>$this->color_name,
            'test_date'=>$this->test_date->format('Y-m-d'),
            'type'=>$this->type_name,
            'status'=>$this->status_name,
        ];
        if ($this->type == 1)
        {
            $data = array_merge($data,[
                'shoulder_width'=> $this->details->shoulder_width,
                'chest_circumference'=> $this->details->chest_circumference,
                'middle_body'=> $this->details->middle_body,
                'buttocks'=> $this->details->buttocks,
                'arm_length'=> $this->details->arm_length,
                'arm_circumference'=> $this->details->arm_circumference,
                'wristband'=> $this->details->wristband,
                'overall_height'=> $this->details->overall_height,
                'one_shoulder'=> $this->details->one_shoulder,
                'back_length'=> $this->details->back_length,
                'from_shoulder_to_chest'=> $this->details->from_shoulder_to_chest,
                'from_shoulder_middle'=> $this->details->from_shoulder_middle,
                'pocket_length'=> $this->details->pocket_length,
            ]);
        }
        return $data;
    }
}
