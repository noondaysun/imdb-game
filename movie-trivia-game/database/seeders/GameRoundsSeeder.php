<?php

namespace Database\Seeders;

use App\Models\GameRounds;
use Illuminate\Database\Seeder;

class GameRoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameRounds::factory()
            ->times(8)
            ->create();
    }
}
