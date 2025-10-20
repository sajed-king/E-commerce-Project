<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
     
        return [
            
        'name_en'=> $this->faker->name(),
        'description_en'=>$this->faker->paragraph(),
        'category_id'=> 1,
        'price'=> $this->faker->randomNumber(2),
        'need_prescription'=> 0,
        'concentration'=> $this->faker->randomFloat(2,1,100),
        'amount'=>$this->faker->randomNumber(1),
        'image'=> 'images/'.fake()->imageUrl,
        'package_insert'=> 'package_inserts/'. fake()->imageUrl,
        'company_id'=> 1,

        ];
    }
}
