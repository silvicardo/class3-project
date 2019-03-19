<?php

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
//ADMISSION PAGE

Route::get('/iscriviti', 'AdmissionController@index')->name('admission.index');
Route::post('/iscriviti', 'AdmissionController@save')->name('admission.save');


//STATIC PAGE

Route::get('/privacyPolicy', 'StaticPageController@privacyPolicy')->name('static_pages.privacy');
Route::get('/workWithUs', 'StaticPageController@workWithUs')->name('static_pages.workWithUs');


//PUBLIC PAGE

/// -> homepage

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');//Ricerca appartamenti in db
Route::get('/apartment', 'ApartmentController@index')->name('apartment');//ricerca dettaglio apt su db
//Route::post('/apartment', 'ApartmentController@post')->name('apartment');//
<<<<<<< HEAD
Route::get('/apartment/{id}', 'ApartmentController@show')->name('apartment.show');//show apartment per id
=======
Route::get('/apartment/{id}', 'ApartmentController@show')->name('apartment.show');
>>>>>>> 25f7ed16551ac9fc3ccd473fbd856f3d1ef89ef9
Route::get('/aptfilter', 'AptfilterController@index')->name('aptfilter');//ricerca filtri su db
//form da includere in public


//PRIVATE PAGE PROPRIETARIO

Route::resource('/users', 'UserController');


//NAVBAR PAGE

Route::get('/trips', 'TripsController@index')->name('trips');

Auth::routes();
