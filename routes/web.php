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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//All Listings
Route::get('/', [ListingController::class, 'index']);

//Show Create Form
Route::get('/listings/create', [ListingController::class, 'create']);

//Store Listing
Route::post('/listings', [ListingController::class, 'store']);

//Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

//Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update']);

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

//LEAVE AT BOTTOM
//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register/Create Form
Route::get('/register',[UserController::class,'create']);

// Create New User
Route::post('/users',[UserController::class, 'store']);

// Log User Out
Route::post('/logout',[UserController::class, 'logout']);

// Show User Login Form
Route::get('/login',[UserController::class,'login']);

// Log User In
Route::post('/users/authenticate',[UserController::class,'authenticate']);


//Examples
Route::get('/hello', function () {
    return response('<h1>Hello World</h1>', 200)
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar');
});

Route::get('/posts/{id}', function ($id) {
    // ddd($id); ddd: Dump, Die, Debug variables
    return response('Post ' . $id);
})->where('id', '[0-9]+'); //regex to only accept numerical values for id

Route::get('/search', function (Request $request) {
    return $request->name . ' ' . $request->city;
});
