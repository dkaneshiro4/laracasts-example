<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });
// The line below is the same as the commented block above
// it's a shorthand.
Route::view('/', 'home');

Route::view('/contact', 'contact');

// Using the Route::resource method means you can't specify an alternative
// identifying column like {job:slug}. You have to use the conventional id column.
// Route::resource('jobs', JobController::class)->middleware('auth');

// A third parameter can be passed in as an array telling which route resources to
// use or exclude
// Route::resource('jobs', JobController::class, [
//     'only' => ['index', 'show']
// ]);

// Below is equivalent to the above route resource, but resource naming
// must follow convention. (index, create, show, store, edit, update, destroy)
// Route::controller(JobController::class)->group(function () {
//     Route::get('/jobs', 'index');
//     Route::get('/jobs/create', 'create');
//     Route::get('/jobs/{job}', 'show');
//     Route::post('/jobs', 'store');
//     Route::get('/jobs/{job}/edit', 'edit');
//     Route::patch('/jobs/{job}', 'update');
//     Route::delete('/jobs/{job}', 'destroy');
// });

// Below individual route-controller statements are equivalent to above route group
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

// The middleware('auth') checks if the user is logged in to use this route to create a job.
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');

// In the route below two middleware types are used. The 'can' middleware uses
// the 'edit-job gate defined in AppServiceProvider::boot method.
// Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware(['auth', 'can:edit-job,job']);

// The route statement below is an alternative to the one just above.
//Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
//    ->middleware('auth')
//    ->can('edit-job', 'job');
//
//Route::patch('/jobs/{job}', [JobController::class, 'update'])
//    ->middleware('auth')
//    ->can('edit-job', 'job');

// Using the 'edit-job' gate assumes in your application that if you can edit a job you can
// delete a job. You may want to use create a different gate if your application allows
// a different type of authorization to delete a job. For example, only an admin can
// delete a job
//Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
//    ->middleware('auth')
//    ->can('edit-job', 'job');


// In the route statements below these use the 'edit' policy defined in JobPolicy
// to check if someone is authorized to edit a job. A policy is an alternative
// to a gate.
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit', 'job');

Route::patch('/jobs/{job}', [JobController::class, 'update'])
    ->middleware('auth')
    ->can('edit', 'job');

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->middleware('auth')
    ->can('edit', 'job');


// Find {job:slug} means to find the job based on the
// column called slug
// Route::get('/jobs/{job:slug}', [JobController::class, 'show']);

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

// The name() method below is used because laravel uses a named route called 'login'
// to redirect to when a user fails the middleware('auth') check.
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
