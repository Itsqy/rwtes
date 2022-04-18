<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegeTableSeeder extends Seeder {

   public function run()
   {
       DB::table('privilege')->delete();

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '1'
           'action_id' => '1'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '1'
           'action_id' => '2'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '1'
           'action_id' => '3'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '1'
           'action_id' => '4'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '2'
           'action_id' => '1'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '2'
           'action_id' => '2'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '2'
           'action_id' => '3'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '2'
           'action_id' => '4'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '3'
           'action_id' => '1'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '3'
           'action_id' => '2'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '3'
           'action_id' => '3'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '3'
           'action_id' => '4'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '4'
           'action_id' => '1'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '4'
           'action_id' => '2'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '4'
           'action_id' => '3'
       ]);

       DB::table('privilege')->insert([
           'user_id' => '1',
           'module_id' => '4'
           'action_id' => '4'
       ]);
    }
}
