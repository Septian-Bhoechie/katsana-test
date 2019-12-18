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
    return view('welcome');
});

Route::prefix('vehicle')->group(function () {

    Route::get('/', 'Vehicle\VehicleController@index')
        ->name("vehicle");
    Route::get('/show/{vehicle}/trips', 'Vehicle\VehicleController@trip')
        ->name("vehicle.trip");
    Route::get('/show/{vehicle}/trips/{trip}/export-csv', 'Vehicle\VehicleController@exportTrip')
        ->name("vehicle.trip.export");
});
