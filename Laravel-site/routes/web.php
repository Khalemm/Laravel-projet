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
    return view('welcome');
});

//routes test
Route::get('dada', 'App\Http\Controllers\Test_AuthController@dada' );
Route::get('dodo', 'App\Http\Controllers\Test_AuthController@dodo' );

//route users
Route::get('users', [UserController::class, @index])->name('users');
Route::get('user/{id}', [UserController::class, @show])->name('user.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
