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

//***************HOMEPAGE***************//

Route::get('/', 'HomeController@index')->name('home');

//*********************************************//
//***************WITH AUTH PAGES***************//
//*********************************************//

//***************PUBLIC PAGES***************//
Route::prefix('apartment')->name('apartment.')->group(function(){

  Route::get('/', 'ApartmentController@index')->name('index');//ricerca dettaglio apt su db
  Route::get('/new', 'ApartmentController@create')->name('create');
  Route::get('/{id}', 'ApartmentController@show')->name('show');
  Route::get('/{id}/edit', 'ApartmentController@edit')->name('edit');
  Route::put('/{id}', 'ApartmentController@update')->name('update');
  Route::post('/', 'ApartmentController@store')->name('store');
  Route::delete('/{id}/delete', 'ApartmentController@destroy')->name('destroy');

});

//***************OWNER PAGES***************//

//prefix Url pagina
//Namespace folder dei controller
//name prefisso rotta per view (per frontend)

Route::prefix('owner')->namespace('Admin')->name('owner.')->group(function(){

  Route::get('/', 'OwnerController@show')->name('show');
  Route::get('/edit', 'OwnerController@edit')->name('edit');
  Route::delete('/delete', 'OwnerController@destroy')->name('destroy');
  Route::get('/profile', 'OwnerController@profile')->name('profile');
  Route::get('/{apartmentId}/sponsor', 'SubscriptionsController@create')->name('sponsor.create');
  Route::get('/sponsor', 'OwnerController@sponsor')->name('sponsor.newfromnav');
  Route::post('/sponsor', 'SubscriptionsController@store')->name('sponsor.store');

});

//***************GUEST PAGES***************//

Route::prefix('guest')->namespace('Admin')->name('guest.')->group(function(){

  Route::get('/', 'GuestController@show')->name('show');
  Route::get('/edit', 'GuestController@edit')->name('edit');
  Route::delete('/delete', 'GuestController@destroy')->name('destroy');
  Route::get('/profile', 'GuestController@profile')->name('profile');

});

//***************MESSAGES PAGES***************//

Route::prefix('messages')->namespace('Admin')->name('messages.')->group(function(){

  Route::get('/', 'MessageController@index')->name('index');
  Route::get('/create', 'MessageController@create')->name('create');
  Route::post('/', 'MessageController@store')->name('store');
  Route::get('/show', 'MessageController@show')->name('show');
  Route::delete('/delete','MessageController@destroy')->name('destroy');

});

//***************LARAVEL AUTH PAGES***************//

Auth::routes();

//***************************************************//
//***************WITH AUTH PAGES - END***************//
//***************************************************//


//********************************************//
//***************NO AUTH PAGES ***************//
//********************************************//

//***************ADMISSION PAGES***************//

Route::get('/iscriviti', 'AdmissionController@index')->name('admission.index');
Route::post('/iscriviti', 'AdmissionController@save')->name('admission.save');

//***************STATIC PAGES***************//

Route::get('/privacyPolicy', 'StaticPageController@privacyPolicy')->name('static_pages.privacy');
Route::get('/workWithUs', 'StaticPageController@workWithUs')->name('static_pages.workWithUs');

//***************PUBLIC PAGES***************//

Route::post('/search', 'SearchController@index')->name('search');//Ricerca appartamenti in db

//form da includere in public
Route::get('/trips', 'TripsController@index')->name('trips');

//**************************************************//
//***************NO AUTH PAGES - END ***************//
//**************************************************//
