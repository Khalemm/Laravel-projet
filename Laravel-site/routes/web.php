<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

//vérification du mail après l'inscription
/*Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');*/

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

/*Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');*/



//quand le compte est activé on a accès aux routes
Route::middleware(['active'])->group( function() {

    //admin 
    Route::get('administration', 'AdminController@administration')->name('user.administration');
    Route::get('user/active/{id}', 'AdminController@activerUser')->name('user.active');
    Route::get('user/desactive/{id}', 'AdminController@desactiverUser')->name('user.desactive');
    Route::get('user/delete/{id}', 'AdminController@supprimerUser')->name('user.delete');
    Route::get('user/admin/{id}', 'AdminController@updateAdminUser')->name('user.admin');
    Route::get('users-no-confirmed', 'AdminController@supprimerUsersNonConfirmes')->name('user.non-confirme');

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
