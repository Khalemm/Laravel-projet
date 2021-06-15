<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('accueil');
});

//routes test
Route::get('dada', 'App\Http\Controllers\Test_AuthController@dada' );
Route::get('dodo', 'App\Http\Controllers\Test_AuthController@dodo' );

Route::get('recherche/partie1','requeteMapController@geocoder')->name('requeteGeocoder');
Route::post('recherche/partie1', 'requeteMapController@postGeocoder')->name('postGeocoder'); //on recup param

Route::get('recherche/partie2', 'requeteMapController@informationsComplementaires')->name('requeteInfo');
Route::post('recherche/partie2', 'requeteMapController@postInformationsComplementaires')->name('postInfo'); //on recup param

//route users
Route::get('users', [UserController::class, @index])->name('users');
Route::get('user/{id}', [UserController::class, @show])->name('user.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/*Route::get('/test', function() {
    return response()->json([
     'stuff' => phpinfo()
    ]);
 });*/