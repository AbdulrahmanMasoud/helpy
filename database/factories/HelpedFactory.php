<?php

namespace Database\Factories;

use App\Models\Helped;
use App\Models\Marker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HelpedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Helped::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::get(['id'])->random()->id,
            'marker_id' => Marker::get(['id'])->random()->id,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
