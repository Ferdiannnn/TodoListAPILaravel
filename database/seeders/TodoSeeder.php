<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<100000;$i++){
            DB::table('todo')->insert([
            'user_id' => rand(1,2),
            'title' => Str::random(10),
            'description'=>Str::random(10)
        ]);
        }
    }
}
