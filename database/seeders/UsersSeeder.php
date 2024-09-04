<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $items = [
            ["user_id"=> "user123456" ,"password"=> Hash::make("123456")],
        ];


        foreach ($items as $item) {
            User::create($item);
        }


    }
}
