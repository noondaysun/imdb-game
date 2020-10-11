<?php

namespace Database\Factories;

use App\Models\GameRounds;
use App\Models\ImdbData;
use App\Models\Sessions;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameRoundsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameRounds::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imdbData = $factor->create(ImdbData::class);
        $guess = $this->faker->year();
        return [
            'session_id' => $factory->create(Sessions::class)->id,
            'guess' => $guess,
            'score' => $guess === $imdbData->year ? 5 : -3,
            'imdb_data_id' => $imdbData->id,
        ];
    }
}
