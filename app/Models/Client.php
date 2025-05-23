<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Définir les champs fillables
    protected $fillable = [
        'nom', 'prenom', 'email', 'tel', 'adresse', 'ville', 'code_postal'
    ];

    public function reservations()
    {
        return $this->hasMany(Calendar::class);
    }
    
}
