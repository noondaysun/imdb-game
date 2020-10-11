<?php

namespace Database\Seeders;

use App\Models\GameSessions;
use Illuminate\Database\Seeder;

class GameSessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameSessions::factory()
            ->times(1)
            ->create();
    }
}
