<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {

    Route::apiResource('/contacts', 'Contact\\ContactController');

    Route::get('/birthdays', 'Birthdays\\BirthdaysController');

    Route::post('/search', 'Search\SearchController');

});


