<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder {

   public function run()
   {
       DB::table('user')->delete();

       DB::table('user')->insert([
           'username' => 'Penghaw',
           'email' => 'rivaldi.logan@hotmail.com', 
           'first_name' => 'Rivaldi',
           'last_name' => 'Logan', 
           'password' => bcrypt('penghaw@123'),
       ]);
    }
}
