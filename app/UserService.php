<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{

    protected $guarded = ['id'];
    public $tablename = 'user_services';


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault();
    }
}
