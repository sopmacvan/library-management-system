<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\ReservationStatus;
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

        $statuses = array('accepted', 'claimed', 'cancelled', 'expired');
        foreach ($statuses as $status) {
            ReservationStatus::create([
                'status_value' => $status
            ]);
        }
    }
}
