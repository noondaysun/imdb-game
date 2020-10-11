<?php

namespace Database\Factories;

use App\Models\GameSessions;
use App\Models\Sessions;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameSessionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameSessions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id_initator' => $factory->create(Sessions::class)->id,
            'session_id_challenger' => $factory->create(Sessions::class)->id,
        ];
    }
}
