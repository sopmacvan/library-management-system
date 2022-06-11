<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Schema::disableForeignKeyConstraints();

        $this->call([

            UsersSeeder::class,
            UserRoleSeeder::class,
            UserStatusSeeder::class,

            CategorySeeder::class,
            AuthorSeeder::class,
            BooksSeeder::class,
            BookAuthorSeeder::class,

            ReservationStatusSeeder::class

        ]);
        Schema::enableForeignKeyConstraints();

    }
}
