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
    return view('rechercheBienGeocoder');
});

//routes test
Route::get('dada', 'Test_AuthController@dada' );
Route::get('dodo', 'Test_AuthController@dodo' );

Route::get('recherche','requeteMapController@geocoder')->name('requeteGeocoder');
Route::post('recherche', 'requeteMapController@postGeocoder')->name('postGeocoder'); //on recup param

//Route::get('recherche2', 'requeteMapController@informationsComplementaires')->name('requeteInfo');
Route::post('recherche2', 'requeteMapController@postInformationsComplementaires')->name('postInfo'); //on recup param

//Route::get('resultat', 'requeteMapController@resultat')->name('resultat');

//routes users
Route::get('users', [UserController::class, @index])->name('users');

Route::get('user/{id}/requete', [UserController::class, @show])->name('user.requete');
Route::get('user/{id}/requete/{reqid}','requeteMapController@supprimerRequete')->name('requete.delete'); //requete/{id}
//Route::redirect('user/{id}/requete/{reqid}', '/user/{id}/requete');

Route::get('user/profil', 'UserController@form_update')->name('user.profil');
Route::post('user/profil', [UserController::class, @update])->name('user.update-profil');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/*Route::get('/test', function() {
    return response()->json([
     'stuff' => phpinfo()
    ]);
 });*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
