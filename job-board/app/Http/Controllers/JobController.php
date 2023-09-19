<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Job::class);

        $filters = request()->only(
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        );

        return view(
            'job.index',
            ['jobs' => Job::with('employer')->latest()->filter($filters)->get()]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): View
    {
        $this->authorize('view', $job);
        
        return view('job.show', ['job' => $job->load('employer.jobs')]);
    }
}