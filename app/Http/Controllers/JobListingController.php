<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::query();
    
        if ($request->has('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->has('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->has('salary')) {
            $query->where('salary', '>=', $request->salary);
        }
    
        return $query->get();
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $jobListing = JobListing::create([
            'title' => $request->title,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'salary' => $request->salary,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return response()->json($jobListing, 201);
    }

    public function update(Request $request, $id)
    {
        $jobListing = JobListing::findOrFail($id);
        $jobListing->update($request->all());

        return response()->json($jobListing);
    }

    public function destroy($id)
    {
        JobListing::destroy($id);

        return response()->json(['message' => 'Job listing deleted']);
    }
}
