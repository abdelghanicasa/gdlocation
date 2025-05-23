<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'title',
        'description',
        'age_conducteur',
        'date',
        'start',
        'end',
        'start_time',
        'end_time',
        'location',
        'montant',
        'etat_paiement',
        'etat_reservation',
        'nombre_jours',
        'nom',
        'prenom',
        'tel',
        'adresse',
        'email',
        'ville',
        'code_postal',
        'reference',
        'notes_admin',
        'color',
        'scooter_id',
        'client_id',
        'montant_promo'
    ];

    public function getEventColorAttribute()
    {
        $colors = [
            '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', 
            '#f1c40f', '#e67e22', '#e74c3c', '#34495e'
        ];
        
        return $colors[crc32($this->nom) % count($colors)];
    }

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    // App\Models\Calendar.php
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function scooter()
    {
        return $this->belongsTo(Scooter::class);
    }

}

