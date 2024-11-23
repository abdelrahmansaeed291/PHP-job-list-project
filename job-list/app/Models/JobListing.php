<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'company_name', 
        'location', 
        'salary', 
        'user_id',
        'experience_level', // Added experience level
        'job_type',         // Added job type
        'industry'          // Added industry
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to filter based on query parameters
    public function scopeFilter(Builder $query, array $filters)
    {
        return $query
            ->when($filters['title'] ?? false, fn ($query, $title) => $query->where('title', 'like', "%{$title}%"))
            ->when($filters['location'] ?? false, fn ($query, $location) => $query->where('location', 'like', "%{$location}%"))
            ->when($filters['salary_min'] ?? false, fn ($query, $min) => $query->where('salary', '>=', $min))
            ->when($filters['salary_max'] ?? false, fn ($query, $max) => $query->where('salary', '<=', $max))
            ->when($filters['experience_level'] ?? false, fn ($query, $level) => $query->where('experience_level', $level))
            ->when($filters['job_type'] ?? false, fn ($query, $type) => $query->where('job_type', $type))
            ->when($filters['industry'] ?? false, fn ($query, $industry) => $query->where('industry', 'like', "%{$industry}%"));
    }
}


