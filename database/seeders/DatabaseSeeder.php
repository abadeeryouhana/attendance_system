<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\database\seeders\UsersSeeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersSeeder::class);
        $items = [
            ["user_id"=> "user123456" ,"password"=> Hash::make("123456")],
        ];


        foreach ($items as $item) {
            User::create($item);
        }
    }
}
