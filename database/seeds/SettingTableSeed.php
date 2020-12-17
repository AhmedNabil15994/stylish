<?php

use Illuminate\Database\Seeder;

class SettingTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email1'=>'info@elmohafez.com',
            'email2'=>'support@elmohafez.com',
            'en'  => ['name' => 'Site Name','address' => 'Cairo','phone1'=>'(100) 3434 55666','phone2'=>'(20) 3434 9999'],
            'ar'  => ['name' => 'اسم الموقع','address' => 'القاهرة','phone1'=>'(100) 3434 55666','phone2'=>'(20) 3434 9999'],
        ];
        \App\Setting::create($data);
    }
}
