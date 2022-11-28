<?php

namespace Database\Factories\Maintenance;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Area;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Department;

class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'intervention_date' => $this->faker->date(),
            'from' => $this->faker->time('H:i'),
            'to' => $this->faker->time('H:i'),
            'type' => $this->faker->randomElement(['issue', 'maintenance']),
            'description' => $this->faker->text(15),
        ];
    }
}
