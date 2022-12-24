<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Routing with the listing controller
//All listings
Route::get('/', [ListingController::class, 'index']);

// show create form
Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

// Store listing
Route::post('/listings',[ListingController::class, 'store'])->middleware('auth');

//show edit form
Route::get('/listings/{listing}/edit',[ListingController::class, 'edit'])->middleware('auth');

// update listing
Route::put('/listings/{listing}',[ListingController::class, 'update'])->middleware('auth');

// delete listing
Route::delete('/listings/{listing}',[ListingController::class, 'destroy'])->middleware('auth');

//show register form
Route::get('/register',[UserController::class, 'create'])->middleware('guest');

// Create new user
Route::post('/users',[UserController::class, 'store']);

// Log out user
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

//show login form
Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');

// Log in user
Route::post('/users/authenticate',[UserController::class, 'authenticate']);

// manage listings
Route::get('/listings/manage',[ListingController::class, 'manage'])->middleware('auth');


//Single listing
Route::get('/listings/{listing}',[ListingController::class, 'show']);




























// routes for simply learn & test

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/ping', function () {
    return response('<h1>Hello world!</h1>',200)    
        ->header('Content-Type', 'text/html')       // setting headers
        ->header('foo', 'bar');                     // setting custom header
});

// getting values from path
Route::get('/posts/{id}', function ($id){
    // Die&DumpDebug helper to debug (also can use dd())
    // ddd($id);     
    return response('Post ' . $id, 200);
})->where('id','[0-9]+');   // setting  constraints for parameters with where and regular expressions

// getting values form request parameters
route::get('search', function(Request $request){
    //dd($request);
    return $request->name . ' ' . $request->age;
});