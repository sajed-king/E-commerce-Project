<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
'name' => $this->faker->randomElement(["(OTC) Medicines","Makeup",
"Vitamins, Supplements, & Wellness","Baby & Child Care",
"Medical Devices & Equipment",
" Home Health","Prescription Medications"]),
        



        ];
    }
}
