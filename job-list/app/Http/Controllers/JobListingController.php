<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobListingController extends Controller
{
    public function __construct()
    {
        // Ensure authentication for CRUD operations
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    // Create a new job listing
    public function store(Request $request)
    {

        if (Auth::user()->role !== 'employer') {
            return response()->json(['message' => 'Unauthorized'], 403);
        };

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
        ]);

        // Get the authenticated user's ID from the token
        $userId = Auth::id(); // Automatically pulled from the token

        // Create the job listing
        $jobListing = JobListing::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'company_name' => $validated['company_name'],
            'location' => $validated['location'],
            'salary' => $validated['salary'],
            'user_id' => $userId,
        ]);

        return response()->json($jobListing, 201); // Return created job listing
    }

    // View all job listings (public)
    public function index()
    {
        return response()->json(JobListing::all());
    }

    // View a single job listing
    public function show($id)
    {
        $jobListing = JobListing::findOrFail($id);
        return response()->json($jobListing);
    }

    // Update a job listing
    public function update(Request $request, $id)
    {

        $jobListing = JobListing::findOrFail($id);

    // Only the owner or an admin can update the job listing
    if ($jobListing->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    };

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'company_name' => 'string|max:255',
            'location' => 'string|max:255',
            'salary' => 'numeric',
        ]);

        $jobListing = JobListing::findOrFail($id);

        // Ensure the authenticated user is the owner of the job listing
        if ($jobListing->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $jobListing->update($validated);
        return response()->json($jobListing);
    }

    // Delete a job listing
    public function destroy($id)
    {
        $jobListing = JobListing::findOrFail($id);

        // Ensure the authenticated user is the owner of the job listing
        if ($jobListing->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $jobListing->delete();
        return response()->json(['message' => 'Job listing deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = JobListing::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->has('salary_min')) {
            $query->where('salary', '>=', $request->salary_min);
        }
        if ($request->has('salary_max')) {
            $query->where('salary', '<=', $request->salary_max);
        }
        if ($request->has('job_type')) {
            $query->where('job_type', $request->job_type);
        }
        if ($request->has('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }
        if ($request->has('industry')) {
            $query->where('industry', $request->industry);
        }

        $perPage = $request->input('per_page', 10); // Default 10 items per page
        $page = $request->input('page', 1);         // Default to the first page

        // Fetch job listings based on filters with pagination
        $jobListings = JobListing::filter($filters)
            ->paginate($perPage, ['*'], 'page', $page);

        

        return response()->json($jobListings);
    }
}

