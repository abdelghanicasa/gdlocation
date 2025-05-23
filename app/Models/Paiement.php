<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Paiement.php
class Paiement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'calendar_id', 'montant', 'methode', 
        'reference', 'statut', 'date_paiement', 'notes'
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2'

    ];

    // App\Models\Paiement.php
    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id', 'id'); // Assurer que la clé étrangère est bien définie
    }

    public function getStatutCouleurAttribute()
    {
        return [
            'réussi' => 'success',  // Changé de 'payé' à 'réussi'
            'en_attente' => 'warning',
            'échoué' => 'danger',
            'remboursé' => 'info'
        ][$this->statut];
    }
}
