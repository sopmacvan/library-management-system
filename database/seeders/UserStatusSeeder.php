<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->truncate();

        $statuses = array('active', 'inactive');
        foreach ($statuses as $status) {
            UserStatus::create([
                'status_value' => $status,
            ]);
        }

    }

}
