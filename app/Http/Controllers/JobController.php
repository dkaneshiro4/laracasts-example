<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 3
        ]);

        // The email property from the user is not explicitly used because Laravel will
        // know to use the email property automatically.
        Mail::to($job->employer->user)->send(
            new JobPosted($job)
        );

        return redirect('/jobs');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        // An alternative way of checking if the logged in
        // user cannot access the edit page.
//        if (Auth::user()->cannot('edit-job', $job)) {
//            abort(403);
//        }

        // Will check if the user can access the edit
        // job page. It will send them to a 403
        // page if they aren't supposed to.
        // Gate::authorize('edit-job', $job);
        // The above is commented out because the 'edit-job'
        // gate is applied via middleware to the route.

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        // authorize (on hold...)
        Gate::authorize('edit-job', $job);

        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
        ]);

        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        return redirect('/jobs/'. $job->id);
    }

    public function destroy(Job $job)
    {
        // authorize
        Gate::authorize('edit-job', $job);

        $job->delete();

        return redirect('/jobs');
    }
}
