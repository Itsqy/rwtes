<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionTableSeeder extends Seeder {

   public function run()
   {
       DB::table('action')->delete();

       DB::table('action')->insert([
           'name' => 'read',
           'description' => 'Read'
       ]);

       DB::table('action')->insert([
           'name' => 'create',
           'description' => 'Create'
       ]);

       DB::table('action')->insert([
           'name' => 'update',
           'description' => 'Edit'
       ]);

       DB::table('action')->insert([
           'name' => 'delete',
           'description' => 'Delete',
       ]);
    }
}
