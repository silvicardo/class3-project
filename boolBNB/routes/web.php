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

//***************ADMISSION PAGES***************//

Route::get('/iscriviti', 'AdmissionController@index')->name('admission.index');
Route::post('/iscriviti', 'AdmissionController@save')->name('admission.save');

//***************STATIC PAGES***************//

Route::get('/privacyPolicy', 'StaticPageController@privacyPolicy')->name('static_pages.privacy');
Route::get('/workWithUs', 'StaticPageController@workWithUs')->name('static_pages.workWithUs');

//***************PUBLIC PAGES***************//

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');//Ricerca appartamenti in db
Route::get('/aptfilter', 'AptfilterController@index')->name('aptfilter');//ricerca filtri su db
//form da includere in public
Route::get('/trips', 'TripsController@index')->name('trips');


//***************WITH AUTH PAGES***************//

//ROTTE apartment/.....
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
});

//ROTTE owner/.....
//prefix Url pagina
//Namespace folder dei controller
//name prefisso rotta per view (per frontend)

Route::prefix('owner')->namespace('Admin')->name('owner.')->group(function(){

  Route::get('/{id}', 'OwnerController@show')->name('show');
  Route::get('/{id}/edit', 'OwnerController@edit')->name('edit');
  Route::post('/{id}/delete', 'OwnerController@destroy')->name('destroy');
  Route::get('/{id}/profile', 'OwnerController@profile')->name('profile');
  Route::get('/{apartmentId}/sponsor', 'SubscriptionsController@create')->name('sponsor.create');
  Route::post('/sponsor', 'SubscriptionsController@store')->name('sponsor.store');

});

Auth::routes();

//ROTTE GUEST

Route::prefix('guest')->namespace('Admin')->name('guest.')->group(function(){

  Route::get('/{id}', 'GuestController@show')->name('show');
  Route::get('/{id}/edit', 'GuestController@edit')->name('edit');
  Route::post('/{id}/delete', 'GuestController@destroy')->name('destroy');
  Route::get('/{id}/profile', 'GuestController@profile')->name('profile');

});


Auth::routes();
