<?php
namespace Database\Factories;

use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobListingFactory extends Factory
{
    protected $model = JobListing::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'location' => $this->faker->city,
            'salary' => $this->faker->numberBetween(50000, 150000),
        ];
    }
}

