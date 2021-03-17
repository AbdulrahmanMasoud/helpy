<?php

namespace Database\Factories;
use App\Models\Marker;
use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

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
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
        ];
    }
}
