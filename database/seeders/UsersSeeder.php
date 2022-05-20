<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

//        for some reason, these seeded users do not work when you use them to login.
//        for now, the only way to add users is to manually register.
//        if anyone knows how to fix this, please do so.


//        $faker = \Faker\Factory::create();
////        create admin
//        User::create([
//            'name' => 'admin',
//            'email' => 'admin@gmail.com',
//            'user_role' => 'admin',
//            'password' => 'asasasas',
//        ]);
//
//
////        create users
//        for ($i = 0; $i < 10; $i++) {
//            User::create([
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => $faker->password,
//            ]);
//        }
    }
}
