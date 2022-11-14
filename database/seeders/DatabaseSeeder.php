<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Department::factory(3)->create();

        $user = new User();
        $user->first_name = "Mauricio";
        $user->last_name = "Ledezma";
        $user->document = "1002";
        $user->type = "2";
        $user->status = "1";
        $user->department_id = 1;
        $user->password = "$2y$10$.ss650lfrHa7YgyJEkPFluVKttaeDlPjhSj1VZRDP5iejQNbI8uxK";
        $user->save();       


    }
}
