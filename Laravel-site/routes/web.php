<?php

use Illuminate\Support\Facades\Route;

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

Route::get('dada', 'App\Http\Controllers\Test_AuthController@dada' );
Route::get('dodo', 'App\Http\Controllers\Test_AuthController@dodo' );

Route::get('recherche/partie1','requeteMapController@geocoder')->name('requeteGeocoder');
Route::post('recherche/partie1', 'requeteMapController@postGeocoder')->name('postGeocoder');

Route::get('recherche/partie2', 'requeteMapController@informationsComplementaires')->name('requeteInfo');
Route::post('recherche/partie2', 'requeteMapController@postInformationsComplementaires')->name('postInfo');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
