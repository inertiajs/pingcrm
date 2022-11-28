<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'phone' => $this->faker->tollFreePhoneNumber,
            'address' => $this->faker->streetAddress,
            'centre' => $this->faker->randomElement(['commercial', 'tech']),
            'department_id' => 8,
            'commune_id' => 48,
            'arrondissement_id' => rand(342, 351),
            'area_id' => rand(3361, 3471),
        ];
    }
}
