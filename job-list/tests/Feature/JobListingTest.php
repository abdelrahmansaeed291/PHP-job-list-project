<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobListingTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_create_job_listing()
    {
        $data = [
            'title' => 'Software Engineer',
            'description' => 'Job Description',
            'company_name' => 'TechCorp',
            'location' => 'New York',
            'salary' => 120000
        ];

        $response = $this->actingAs($this->user, 'api')->postJson('/job-listings', $data);

        $response->assertStatus(201)
                 ->assertJson(['title' => 'Software Engineer']);
    }

    /** @test */
    public function authenticated_user_can_update_own_job_listing()
    {
        $jobListing = JobListing::factory()->create(['user_id' => $this->user->id]);

        $data = ['title' => 'Updated Job Title'];

        $response = $this->actingAs($this->user, 'api')->putJson("/job-listings/{$jobListing->id}", $data);

        $response->assertStatus(200)
                 ->assertJson(['title' => 'Updated Job Title']);
    }

    /** @test */
    public function authenticated_user_can_delete_own_job_listing()
    {
        $jobListing = JobListing::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'api')->deleteJson("/job-listings/{$jobListing->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('job_listings', ['id' => $jobListing->id]);
    }

    /** @test */
    public function user_cannot_delete_others_job_listing()
    {
        $otherUser = User::factory()->create();
        $jobListing = JobListing::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user, 'api')->deleteJson("/job-listings/{$jobListing->id}");

        $response->assertStatus(403);
    }
}
