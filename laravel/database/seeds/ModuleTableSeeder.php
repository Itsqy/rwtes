<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder {

   public function run()
   {
       DB::table('module')->delete();

       DB::table('module')->insert([
           'name' => 'user',
           'description' => 'User Management'
       ]);

       DB::table('module')->insert([
           'name' => 'module',
           'description' => 'Modules'
       ]);

       DB::table('module')->insert([
           'name' => 'action',
           'description' => 'Actions'
       ]);

       DB::table('module')->insert([
           'name' => 'privilege',
           'description' => 'User Permissions',
       ]);
    }
}
