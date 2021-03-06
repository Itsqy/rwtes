<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(PrivilegeTableSeeder::class);
        $this->call(UserRole::class);
    }
}
