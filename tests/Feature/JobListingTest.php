<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobListingTest extends TestCase
{
    use RefreshDatabase; // This ensures that the database is reset after each test

    public function test_job_listing_creation()
    {
        // Create a test user
        $user = User::factory()->create();

        // Act as the created user
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/job-listings', [
            'title' => 'Software Engineer',
            'company_name' => 'XYZ Corp',
            'location' => 'New York',
            'salary' => 60000,
            'description' => 'Developing software...',
        ]);

        // Assert that the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the response contains the correct JSON structure
        $response->assertJsonStructure([
            'id', 'title', 'company_name', 'location', 'salary', 'description', 'user_id', 'created_at', 'updated_at'
        ]);
    }
}
