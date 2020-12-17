<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'Admin',
            'username'=>'admin',
            'email'=>'mahmoudnada5050@gmail.com',
            'phone'=>'01208971865',
            'password'=>bcrypt('123456'),
        ]);
    }
}
