<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Bien extends Model
{
    use HasFactory;

    public function requetes_biens()
    {
        return $this->belongsToMany(User::class); //liaison entre Bien et User
    }
}
