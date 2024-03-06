<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
        Rating::factory()->count(5)->for(
            Product::factory(), 'rateable'
        )->create();

        Rating::factory()->count(5)->for(
            Product::factory(), 'rateable'
        )->create();


        Rating::factory()->count(5)->for(
            Category::factory(), 'rateable'
        )->create();
        */

        Rating::factory()->count(10)->create();
    }
}
