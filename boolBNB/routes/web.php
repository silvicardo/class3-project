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
Route::get('/apartment/new', 'ApartmentController@create')->name('apartment.create');
Route::get('/apartment/{id}', 'ApartmentController@show')->name('apartment.show');

Route::get('/aptfilter', 'AptfilterController@index')->name('aptfilter');//ricerca filtri su db
//form da includere in public


//PRIVATE PAGE PROPRIETARIO

Route::resource('/users', 'UserController');
Route::get('/admin', 'Admin\HomeController@index')->name('admin.home')->middleware('auth');
Route::get('/admin/apartment', 'Admin\ApartmentController@index')->name('admin.apartment.index');





//NAVBAR PAGE

Route::get('/trips', 'TripsController@index')->name('trips');

Auth::routes();
