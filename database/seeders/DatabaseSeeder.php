<?php

namespace Database\Seeders;

use App\Models\Helped;
use App\Models\Marker;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Marker::factory(30)->create();
        Helped::factory(10)->create();
    }
}
