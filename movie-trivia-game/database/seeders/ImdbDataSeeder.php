<?php

namespace Database\Seeders;

use App\Models\ImdbData;
use Illuminate\Database\Seeder;

class ImdbDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImdbData::factory()
            ->times(30)
            ->create();
    }
}
