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
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify'); //on renvoie l'utilisateur à l'accueil après avoir validé son mail

Route::get('/email/verification-notification', function (Request $request) { //on renvoie un lien à l'utilisateur
    $request->user()->sendEmailVerificationNotification();
    return back()->with('info','Un nouveau lien de vérification vous a été envoyé par mail.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//quand le compte de l'utilisateur est activé il a accès aux pages
Route::middleware(['active'])->group( function() {

    //admin 
    Route::get('administration', 'AdminController@administration')->name('user.administration');
    Route::get('user/active/{id}', 'AdminController@activerUser')->name('user.active');
    Route::get('user/desactive/{id}', 'AdminController@desactiverUser')->name('user.desactive');
    Route::get('user/delete/{id}', 'AdminController@supprimerUser')->name('user.delete');
    Route::get('user/admin/{id}', 'AdminController@updateAdminUser')->name('user.admin');
    Route::get('users-no-confirmed', 'AdminController@supprimerUsersNonConfirmes')->name('user.non-confirme');
    Route::post('user/abonnement/{id}', 'AdminController@updateAbonnementUser')->name('user.abonnement');
    Route::get('user/delete/abonnement/{id}', 'AdminController@supprimerAbonnementUser')->name('user.delete-abonnement');

    //recherche
    Route::get('recherche','requeteMapController@geocoder')->name('requeteGeocoder');
    Route::post('recherche', 'requeteMapController@postGeocoder')->name('postGeocoder'); //on recup param

    Route::get('recherche2', 'requeteMapController@geocoder')->name('requeteInfo');
    Route::post('recherche2', 'requeteMapController@postInformationsComplementaires')->name('postInfo'); //on recup param

    //requetes de l'utilisateur
    Route::get('user/requete', 'UserController@show')->name('user.requete');
    Route::get('user/requete/{reqid}','requeteMapController@supprimerRequete')->name('requete.delete');
    Route::get('requete/{reqid}','requeteMapController@voirRequete')->name('requete.show');

    //profil de l'utilisateur
    Route::get('user/profil', 'UserController@form_update')->name('user.profil');
    Route::post('user/profil', 'UserController@updateProfil')->name('user.update-profil');
    Route::post('user/profil/entreprise', 'UserController@updateEntreprise')->name('user.update-entreprise');
    Route::post('user/parametres', 'UserController@updateMdp')->name('user.update-mdp');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
