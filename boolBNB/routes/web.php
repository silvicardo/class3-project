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


Route::prefix('apartment')->name('apartment.')->group(function(){

  Route::get('/', 'ApartmentController@index')->name('index');//ricerca dettaglio apt su db

  Route::get('/new', 'ApartmentController@create')->name('create');
    Route::get('/{id}', 'ApartmentController@show')->name('show');
  Route::get('/{id}/edit', 'ApartmentController@edit')->name('edit');

  Route::post('/{id}', 'ApartmentController@update')->name('update');
  Route::post('/', 'ApartmentController@store')->name('store');

  Route::post('/{id}/delete', 'ApartmentController@destroy')->name('destroy');
  Route::get('/', 'HomeController@index')->name('home');
   // Route::resource('/', 'ApartmentController');
  // Route::resource('/categories', 'CategoryController');
});



Route::get('/aptfilter', 'AptfilterController@index')->name('aptfilter');//ricerca filtri su db
//form da includere in public


//PRIVATE PAGE PROPRIETARIO

Route::resource('/users', 'UserController');
Route::get('/admin', 'Admin\HomeController@index')->name('admin.home')->middleware('auth');
Route::get('/admin/apartment', 'Admin\ApartmentController@index')->name('admin.apartment.index');





//NAVBAR PAGE

Route::get('/trips', 'TripsController@index')->name('trips');


// Route::get('/user-dashboard', 'HomeController@user')->name('user.dashboard');

Auth::routes();
