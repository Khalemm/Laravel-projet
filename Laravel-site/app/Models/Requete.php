<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Requete extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'age_bien',
        'type_bien',
        'nombre_pieces',
        'prix_min',
        'prix_max',
        'longitude',
        'latitude',
        'adresse',
        'code_postal',
        'nom_commune',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //une requete appartient à un user
    }
}
