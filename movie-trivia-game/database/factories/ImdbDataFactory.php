<?php

namespace Database\Factories;

use App\Models\ImdbData;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImdbDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ImdbData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(),
            'year' => $this->faker->year(),
            'poster' => $this->faker->image(
                sys_get_temp_dir(),
                600,
                600,
                'cats'
            ),
        ];
    }
}
