<?php

namespace Database\Factories;

use App\Models\DepartmentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DepartmentModel>
 */
class DepartmentFactory extends Factory
{
    protected $model = DepartmentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
