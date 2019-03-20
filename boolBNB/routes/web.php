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
Route::get('/owner-dashboard/{id}', 'HomeController@owner')->name('owner.dashboard');
Route::get('/iscriviti', 'AdmissionController@index')->name('admission.index');
Route::post('/iscriviti', 'AdmissionController@save')->name('admission.save');


//STATIC PAGE

Route::get('/privacyPolicy', 'StaticPageController@privacyPolicy')->name('static_pages.privacy');
Route::get('/workWithUs', 'StaticPageController@workWithUs')->name('static_pages.workWithUs');


//PUBLIC PAGE

/// -> homepage

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');//Ricerca appartamenti in db
Route::get('/apartment', 'ApartmentController@index')->name('apartment.index');//ricerca dettaglio apt su db


Route::get('/apartment/new', 'ApartmentController@create')->name('apartment.create');
Route::get('/apartment/{id}', 'ApartmentController@show')->name('apartment.show');
Route::post('/apartment', 'ApartmentController@store')->name('apartment.store');

Route::get('/aptfilter', 'AptfilterController@index')->name('aptfilter');//ricerca filtri su db
//form da includere in public


//PRIVATE PAGE PROPRIETARIO

Route::resource('/users', 'UserController');


//NAVBAR PAGE

Route::get('/trips', 'TripsController@index')->name('trips');


// Route::get('/user-dashboard', 'HomeController@user')->name('user.dashboard');

Auth::routes();
