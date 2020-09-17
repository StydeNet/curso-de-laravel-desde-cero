<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
        ];
    }
}
