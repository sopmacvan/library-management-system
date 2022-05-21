<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservation_statuses')->truncate();

        $faker = \Faker\Factory::create();
        Book::create([
            'status_value' => 'awaiting claim',
        ]);
        Book::create([
            'status_value' => 'claimed',
        ]);
    }
}
