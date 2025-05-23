<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Définir les champs fillables
    protected $fillable = [
        'client_id',
        'date',
        'montant',
        'reference',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
