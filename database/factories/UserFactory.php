<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function configure()
    {
        return $this->afterCreating(function ($user) {
            $user->profile()->save(UserProfile::factory()->make());
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$ZwGRn793jmScCZ8c9s3mR.6YIfCcVGghmAf3PGgf5xiZR5lvTYIey',
            'remember_token' => Str::random(10),
            'role' => 'user',
            'active' => true,
        ];
    }

    public function inactive()
    {
        return $this->state(function () {
            return [
                'active' => false,
            ];
        });
    }
}
