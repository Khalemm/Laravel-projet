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
})->name('accueil');

//routes test
Route::get('dada', 'Test_AuthController@dada' );
Route::get('dodo', 'Test_AuthController@dodo' );

//inscription
Route::get('registered', 'HomeController@registered')->name('registered');

//quand le compte est activé on a accès aux routes
Route::middleware(['active'])->group( function() {

    //admin
    Route::get('users', 'AdminController@index')->name('users');
    Route::get('user/active/{id}', 'AdminController@activerUser')->name('user.active');
    Route::get('user/desactive/{id}', 'AdminController@desactiverUser')->name('user.desactive');
    Route::get('user/delete/{id}', 'AdminController@supprimerUser')->name('user.delete');
    Route::get('user/admin/{id}', 'AdminController@updateAdminUser')->name('user.admin');
    Route::get('users', 'AdminController@voirUser')->name('user.voir'); //user.profil ?

    Route::get('user/administration', 'AdminController@administration')->name('user.administration');

    //recherche
    Route::get('recherche','requeteMapController@geocoder')->name('requeteGeocoder');
    Route::post('recherche', 'requeteMapController@postGeocoder')->name('postGeocoder'); //on recup param

    Route::get('recherche2', 'requeteMapController@geocoder')->name('requeteInfo');
    Route::post('recherche2', 'requeteMapController@postInformationsComplementaires')->name('postInfo'); //on recup param
    //Route::get('resultat', 'requeteMapController@geocoder')->name('resultat');

    //requetes de l'utilisateur
    Route::get('user/requete', 'UserController@show')->name('user.requete');
    Route::get('user/requete/{reqid}','requeteMapController@supprimerRequete')->name('requete.delete'); //
    Route::get('requete/{reqid}','requeteMapController@voirRequete')->name('requete.show');

    //profil de l'utilisateur
    Route::get('user/profil', 'UserController@form_update')->name('user.profil');
    Route::post('user/profil', 'UserController@updateProfil')->name('user.update-profil');
    Route::post('user/profil/entreprise', 'UserController@updateEntreprise')->name('user.update-entreprise');
    //Route::get('user/profil/abonnement')->name('user.abonnement');

    //route abonnements
    Route::get('abonnements', 'AbonnementController@showAbonnement')->name('abonnements');
    Route::get('user/profil/abonnement/{id}', 'UserController@updateAbonnement')->name('user.update-abonnement');

});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';*/

/*Route::get('/test', function() {
    return response()->json([
     'stuff' => phpinfo()
    ]);
 });*/
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
