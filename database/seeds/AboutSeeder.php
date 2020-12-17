<?php

use App\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'en'  => ['title' => 'About us','desc' => 'About us description'],
            'ar'  => ['title' => 'من نحن','desc' => 'وصف من نحن'],
        ];
        About::create($data);
    }
}
