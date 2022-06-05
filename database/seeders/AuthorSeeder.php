<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->truncate();

        $faker = \Faker\Factory::create();
        for ($i=0; $i<10; $i++) {
            Author::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName
            ]);
        }
    }
}
