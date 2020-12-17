<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','location'];
    protected $guarded = ['id'];

    public function trash()
    {
        $this->deleteTranslations();
        $this->delete();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
