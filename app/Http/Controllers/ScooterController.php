<?php

namespace App\Http\Controllers;

use App\Models\Scooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScooterController extends Controller
{
    public function index()
    {
        $scooters = Scooter::withCount('reservations')->get();
        return view('admin.pages.scooters.index', compact('scooters'));
    }

    public function create()
    {
        return view('admin.pages.scooters.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'modele' => 'required|string|max:100',
            'plaque_immatriculation' => 'nullable',
            'statut' => 'required|in:disponible,hors_service',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kilometrage' => 'nullable',
            'annee' => 'nullable',
            'caracteristiques' => 'nullable|string',
            'prix_journalier'=> 'nullable',
            'nbr_scooter'=> 'string',
        ]);
    
        // Gestion de la photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('scooters', 'public');
        }
    
        // Création
        Scooter::create($validated);
    
        return redirect()->route('scooters.index')
                       ->with('success', 'Scooter ajouté avec succès');
    }

    public function edit(Scooter $scooter)
    {
        return view('admin.pages.scooters.edit', compact('scooter'));
    }

    public function update(Request $request, Scooter $scooter)
    {
        // dd($request->all());
        $validated = $request->validate([
            'modele' => 'required|string|max:100',
            'plaque_immatriculation' => 'string',
            'statut' => 'required|in:disponible,en_maintenance,reserve,hors_service',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kilometrage' => 'integer|min:0',  
            'annee' => 'integer',
            'caracteristiques' => 'nullable|string',
            'nbr_scooter' => 'nullable',
        ]);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($scooter->photo) {
                Storage::disk('public')->delete($scooter->photo);
            }
            $validated['photo'] = $request->file('photo')->store('scooters', 'public');
        }

        $scooter->update($validated);

        return redirect()->route('scooters.index')->with('success', 'Scooter mis à jour avec succès');
    }

    public function destroy(Scooter $scooter)
    {
        if ($scooter->photo) {
            Storage::disk('public')->delete($scooter->photo);
        }
        
        $scooter->delete();
        
        return redirect()->route('scooters.index')->with('success', 'Scooter supprimé avec succès');
    }

    public function disponibilite(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        
        $scootersDisponibles = Scooter::whereDoesntHave('reservations', function($query) use ($dateDebut, $dateFin) {
            $query->where(function($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('start', [$dateDebut, $dateFin])
                  ->orWhereBetween('end', [$dateDebut, $dateFin])
                  ->orWhere(function($q) use ($dateDebut, $dateFin) {
                      $q->where('start', '<', $dateDebut)
                        ->where('end', '>', $dateFin);
                  });
            });
        })->where('statut', 'disponible')->get();

        return view('admin.scooters.disponibilite', compact('scootersDisponibles', 'dateDebut', 'dateFin'));
    }
}