<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $model = $this->faker->randomElement([
            [
                'id' => Category::query()->inRandomOrder()->first()->id,
                'model' => Category::class    
            ],
            [
                'id' => Product::query()->inRandomOrder()->first()->id,
                'model' => Product::class    
            ]
        ]);

        return [
            'rateable_type' => $model['model'], 
            'rateable_id' => $model['id'],
            'average' => $this->faker->numberBetween(1,5),
            'user_id' => User::query()->inRandomOrder()->first()->id,
        ];
    }
}
