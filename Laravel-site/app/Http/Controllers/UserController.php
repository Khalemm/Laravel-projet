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
        $user =  auth()->user(); //cherche l'utilisateur par l'id
        
        $requetes = $user->requetes()->orderBy('created_at', 'desc')->get();

        return view('user_requete', [ 'user' => $user, 'requetes' => $requetes]);
    }

    public function form_update() { //affiche le profil de l'utilisateur
        $user =  auth()->user();
        return view('user_profil', [ 'user' => $user ]);
    }

    public function updateProfil(Request $requete) //met à jour le profil de l'utilisateur
    {
        $validator = Validator::make($requete->all(),[ //Valide les champs du formulaire
            'name'=>'required|regex:/^[a-zA-Z]+$/u',
            'last_name'=>"required|regex:/^[a-zA-Z' -]+$/u", 
            'tel_fixe'=>'digits:10|nullable',
            'tel_mobile' =>'digits:10|nullable'
            ],[
            //controles de validité
            'name.required'=>'Veuillez renseigner ce champ.',
            'last_name.required'=>'Veuillez renseigner ce champ.', //nom et prenom obligatoire
            'name.regex'=>'Champ non valide.',
            'last_name.regex'=>'Champ non valide.', //non valide si l'utilisateur saisit des caractères spéciaux
            'tel_fixe.digits'=>'Veuillez entrer 10 valeurs.',
            'tel_mobile.digits'=>'Veuillez entrer 10 valeurs.', 
        ]);

        if( !$validator->passes() ){ //si le formulaire n'est pas valide on affiche des messages d'erreur
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
        //modification
        $update = auth()->user()->update([ //on rentre les valeurs dans la base de données
            'name' => $requete->name,
            'last_name' => $requete->last_name,
            'tel_fixe' => $requete->tel_fixe,
            'tel_mobile' => $requete->tel_mobile
        ]);
        
        if( !$update ){ //message d'erreur si la mise à jour a échoué
            return redirect()->back()->with('error','Mise à jour échouée');
        }else{
            return response()->json(['status'=>1,'msg'=>'Votre profil a été mis à jour']);
        }
        }
    }

    public function updateEntreprise(Request $requete) //met à jour les infos de son entreprise
    {
        $validator = Validator::make($requete->all(),[ //Valide les champs du formulaire
            'nom_entreprise'=>'string|nullable',
            'adresse_entreprise'=>'string|nullable',
            'code_postal'=>'digits:5|nullable',
            'ville_entreprise' =>"regex:/^[a-zA-Z' -]+$/u|nullable"
            ],[
            //controles de validité
            'code_postal.digits'=>'Veuillez entrer 5 valeurs.',
            'ville_entreprise.regex'=>'Champ non valide.', ////non valide si l'utilisateur saisit des caractères spéciaux
        ]);

        if( !$validator->passes() ){ //si le formulaire n'est pas valide on affiche des messages d'erreur
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
        //modification
        $update = auth()->user()->update([ //on rentre les valeurs dans la base de données
            'nom_entreprise' => $requete->nom_entreprise,
            'adresse_entreprise' => $requete->adresse_entreprise,
            'code_postal' => $requete->code_postal,
            'ville_entreprise' => $requete->ville_entreprise
        ]);
        
        if( !$update ){ //message d'erreur si la mise à jour a échouée
            return redirect()->back()->with('error','Mise à jour échouée');
        }else{
            return response()->json(['status'=>1,'msg'=>'Votre entreprise a été mise à jour']);
        }
        }
    }

    public function updateMdp(Request $requete) //changer son mdp
    {
        $validator = Validator::make($requete->all(),[ //Valide les champs du formulaire
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

        if( !$validator->passes() ){ //si le formulaire n'est pas valide on affiche messages d'erreur
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
