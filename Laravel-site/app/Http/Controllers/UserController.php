<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //faut se connecter pour avoir accès
    }

    public function show()
    {
        $user =  auth()->user(); //cherche user par l'id

        return view('user_requete', [ 'user' => $user]);
    }

    public function form_update() {
        $user =  auth()->user();
        return view('user_profil', [ 'user' => $user ]);
    }

    public function updateProfil(Request $requete) //mettre à jour le profil de l'utilisateur
    {
        $validator = Validator::make($requete->all(),[ //Valider le formulaire
            'name'=>'required|regex:/^[a-zA-Z]+$/u',
            'last_name'=>'required|regex:/^[a-zA-Z]+$/u',
            'tel_fixe'=>'digits:10|nullable',
            'tel_mobile' =>'digits:10|nullable'
            ],[
            //controles de validité
            'name.required'=>'Veuillez renseigner ce champ.',
            'last_name.required'=>'Veuillez renseigner ce champ.',
            'name.regex'=>'Champ non valide.',
            'last_name.regex'=>'Champ non valide.',
            'tel_fixe.digits'=>'Veuillez entrer 10 valeurs.',
            'tel_mobile.digits'=>'Veuillez entrer 10 valeurs.',
        ]);

        if( !$validator->passes() ){ //si le form n'est pas valide on a des messages d'erreur
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
        //modification
        $update = auth()->user()->update([
            'name' => $requete->name,
            'last_name' => $requete->last_name,
            'tel_fixe' => $requete->tel_fixe,
            'tel_mobile' => $requete->tel_mobile
        ]);
        return response()->json(['status'=>1,'msg'=>'Votre profil a été mis à jour']);
        }
    }

    public function updateEntreprise(Request $requete) //mettre à jour les infos de son entreprise
    {
        $validator = Validator::make($requete->all(),[ //Valider le formulaire
            'nom_entreprise'=>'string|nullable',
            'adresse_entreprise'=>'string|nullable',
            'code_postal'=>'digits:5|nullable',
            'ville_entreprise' =>"regex:/^[a-zA-Z' -]+$/u|nullable"
            ],[
            //controles de validité
            'code_postal.digits'=>'Veuillez entrer 5 valeurs.',
            'ville_entreprise.regex'=>'Champ non valide.',
        ]);

        if( !$validator->passes() ){ //si le form n'est pas valide on a des messages d'erreur
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
        //modification
        $update = auth()->user()->update([
            'nom_entreprise' => $requete->nom_entreprise,
            'adresse_entreprise' => $requete->adresse_entreprise,
            'code_postal' => $requete->code_postal,
            'ville_entreprise' => $requete->ville_entreprise
        ]);
        return response()->json(['status'=>1,'msg'=>'Votre entreprise a été mise à jour']);
        }
    }

    /*public function updateAbonnement(Request $requete)
    {
        $user = auth()->user();

        if( $requete->input(['oui']) )
        {
            $user->abonnement = 1;
            $user->date_abonnement = date('Y-m-d H:i:s');
            
        }

        $date_fin_abonnement = $requete->input(['date_fin_abonnement']);
        if($date_fin_abonnement == 'mensuel')
        {
            $user->date_fin_abonnement = date('Y-m-d', strtotime(date("Y-m-d", time()) . " + 1 month"));
        }else{
            $user->date_fin_abonnement = date('Y-m-d', strtotime(date("Y-m-d", time()) . " + 1 year"));
        }
        $user->save();

        return redirect()->back()->withSuccess("Votre abonnement a été mis à jour");
    }*/

    public function updateMdp(Request $requete) //changer son mdp
    {
        $validator = Validator::make($requete->all(),[ //Valider le formulaire
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !Hash::check($value, Auth::user()->password) ){ //si le mdp actuel n'est pas le bon
                        return $fail(__('Mot de passe incorrect.'));
                    }
                },
            ],
            'newpassword'=>'required|min:8',
            'password-confirm'=>'required|same:newpassword'
         ],[
            //controles de validité
            'newpassword.min'=>'Le mot de passe doit contenir au moins 8 caractères.',
            'password-confirm.same'=>'Le champ de confirmation du mot de passe ne correspond pas.'
         ]);

        if( !$validator->passes() ){ //si le form n'est pas valide on a des messages d'erreur
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
        //changement du mdp
        $update = auth()->user()->update(['password'=>Hash::make($requete->newpassword)]);

        if( !$update ){ //message d'erreur si changement échoué
            return redirect()->back()->with('error','Changement du mot de passe échoué');
        }else{
            return response()->json(['status'=>1,'msg'=>'Votre mot de passe a bien été mis à jour']);
        }
        }
    }

}
