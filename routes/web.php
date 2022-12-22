<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

//All listings
Route::get('/',function(){
    return view('listings', [
            'heading' => 'Latest listings',
            'listings' => Listing::all(),   //calling static method from Listing model
        ]
    );
});

//Single listing
Route::get('/listings/{id}',function($id){
    return view('listing', [
            'listing' => Listing::find($id),   //calling static method from Listing model
        ]
    );
})->where('id','[0-9]+');

































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