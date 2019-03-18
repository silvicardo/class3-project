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

Route::get('/', function () {
    return view('home');
});

Route::get('/iscriviti', 'AdmissionController@index')->name('admission.index');
Route::post('/iscriviti', 'AdmissionController@save')->name('admission.save');



Route::get('/', 'HomeController@index')->name('home');

//static page

Route::get('/privacyPolicy', 'StaticPageController@privacyPolicy')->name('static.privacy');
Route::get('/workWithUs', 'StaticPageController@workWithUs')->name('static.work_with_us');

//public page

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'searchController@index')->name('search');//ricerca apt su db
Route::get('/apartment', 'apartmentController@index')->name('apartment');//ricerca dettaglio apt su db
Route::get('/aptfilter', 'aptfilterController@index')->name('apartment');//ricerca filtri su db
//form da includere in public



//private page PROPRIETARIO

Route::resource('/users', 'UserController');





//navbar page

Route::get('/viaggi', 'TripsController@index')->name('trips');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
