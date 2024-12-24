<?php

namespace Database\Factories;
use App\Models\Csv;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\csv>
 */
class CsvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model=Csv::class;

    public function definition(): array
    {
        return [
            'first_name'=>$this->faker()->firstName(),
            'last_name'=>$this->faker()->lastName(),
            'age'=>$this->faker()->numberBetween(18,60),
            'gender'=>$this->faker()->randomElement(['male','female']),
        ];
    }
}
