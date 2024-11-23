<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobListingSearchTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        // Create job listings for search testing
        JobListing::factory()->create([
            'title' => 'Software Engineer',
            'location' => 'New York',
            'salary' => 120000,
        ]);
        JobListing::factory()->create([
            'title' => 'Data Scientist',
            'location' => 'California',
            'salary' => 150000,
        ]);
    }

    /** @test */
    public function user_can_search_by_title()
    {
        $response = $this->actingAs($this->user, 'api')->getJson('/job-listings?title=Software Engineer');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['title' => 'Software Engineer']);
    }

    /** @test */
    public function user_can_filter_by_location()
    {
        $response = $this->actingAs($this->user, 'api')->getJson('/job-listings?location=California');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['location' => 'California']);
    }

    /** @test */
    public function user_can_filter_by_salary_range()
    {
        $response = $this->actingAs($this->user, 'api')->getJson('/job-listings?salary_min=130000&salary_max=160000');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['salary' => 150000]);
    }
}
