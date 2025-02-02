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
Route::resource('jobs', JobController::class);

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
// Route::get('/jobs', [JobController::class, 'index']);
// Route::get('/jobs/create', [JobController::class, 'create']);
// Route::get('/jobs/{job}', [JobController::class, 'show']);
// Route::post('/jobs', [JobController::class, 'store']);
// Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);
// Route::patch('/jobs/{job}', [JobController::class, 'update']);
// Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

// Find {job:slug} means to find the job based on the
// column called slug
// Route::get('/jobs/{job:slug}')

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
