<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable=[
        'shoulder_width','chest_circumference','middle_body','buttocks','arm_length','arm_circumference','wristband',
        'overall_height','one_shoulder','back_length','from_shoulder_to_chest','from_shoulder_middle','pocket_length','order_id'
    ];

    public $timestamps = false;
}
