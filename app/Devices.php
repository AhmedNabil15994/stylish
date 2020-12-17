<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Devices extends Model
{

    use Notifiable;
    protected $guarded = ['id'];
    public $timestamps = false;
    public $tablename = 'devices';

    public function routeNotificationForFcm() {
        return $this->device_token;
    }
}
