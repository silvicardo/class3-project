<?php

use Illuminate\Http\Request;

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


//Tutti gli url delle rotte iniziano con /api/
//il namespace fa riferimento ai controller -> App/Http/Controllers/Api/quiSonoIcontroller

//rotte api AUTENTICATE

Route::middleware('api.auth')->namespace('Api')->group(function() {

    Route::get('/braintree/token', 'BraintreeTokenController@token');
    Route::post('/apartment/update-nr-of-views', 'ApartmentController@updateNrOfViews');
    Route::get('/apartment/stats','ApartmentController@apartmentStats');

});

//rotte api NON autenticate
Route::namespace('Api')->group(function() {
    Route::post('/search-city', 'SearchController@getApartmentsByCity');
    //Template rotte Api ()
    // Route::get('/qualcosa', 'QualcosaController@index');
    // Route::post('/qualcosa', 'QualcosaController@create');
    // Route::get('/qualcosa/{id}', 'QualcosaController@show');
    // Route::post('/qualcosa/{id}', 'QualcosaController@update');
    // Route::post('/qualcosa/{id}/delete', 'QualcosaController@destroy');

});
