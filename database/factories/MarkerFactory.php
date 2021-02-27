<?php

namespace Database\Factories;

use App\Models\Marker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Marker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => User::get(['id'])->random()->id,
        'title' => $this->faker->sentence(3),
        'gender' =>$this->faker->randomElement(['ذكر','انثى']),
        'mental_state' =>$this->faker->randomElement(['سوي عقليا','غير سوي عقليا']),
        'adult' =>$this->faker->randomElement(['طفل','بالغ','مُسن']),
        'description' => $this->faker->paragraph(4),
        'latitude' => $this->faker->randomFloat(9,9,85),
        'longitude' => $this->faker->randomFloat(9,9,85),
        'status' => $this->faker->randomElement([1,0]),
        
        
        ];
    }
}
