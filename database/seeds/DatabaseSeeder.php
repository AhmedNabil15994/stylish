<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingTableSeed::class);
        $this->call(LocalTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(AboutSeeder::class);
    }
}
