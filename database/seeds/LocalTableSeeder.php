<?php

use Illuminate\Database\Seeder;

class LocalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataArray = [
            [
                'code'  => 'en',
                'en'  => ['name' => 'English'],
                'ar'  => ['name' => 'الانجليزية'],
            ],[
                'code'  => 'ar',
                'en'  => ['name' => 'Arabic'],
                'ar'  => ['name' => 'العربية'],
            ]
        ];
        foreach ($dataArray as $data)
            \App\Local::create($data);
    }
}
