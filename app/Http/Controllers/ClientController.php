<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Liste des clients avec recherche par nom, email, téléphone
    public function index(Request $request)
    {
        $query = Client::withCount('reservations'); // 👈 ajoute withCount ici
    
        // Filtrage des clients par nom, email, téléphone
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tel', 'like', "%{$search}%")
                  ->orWhere('cd_client', 'like', "%{$search}%");
            });
        }
    
        // Récupérer les clients avec pagination
        $clients = $query->paginate(10);
    
        return view('admin.pages.clients.index', compact('clients'));
    }
    

    // Fiche client détaillée
    public function show($id)
    {
        $client = Client::findOrFail($id);

        // Récupérer l'historique des locations du client
        $historiqueLocations = $client->reservations; // Si une relation 'locations' existe

        // Calculer le total dépensé
        $totalDepense = $client->reservations->sum('montant'); // Si chaque location a un champ 'montant'

        // Dernière réservation
        $derniereReservation = $client->reservations()->latest()->first();

        return view('admin.pages.clients.show', compact('client', 'historiqueLocations', 'totalDepense', 'derniereReservation'));
    }

    public function create()
    {
        return view('admin.pages.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255',
            'prenom'      => 'required|string|max:255',
            'email'       => 'required|email|unique:clients,email',
            'tel'         => 'required|string|max:20',
            'adresse'     => 'nullable|string',
            'ville'       => 'required|string|max:100',
            'code_postal' => 'required|string|max:10',
            'cd_client' => 'nullable|string|max:20',
        ]);
    
        Client::create($validated);
    
        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès !');
    }

    // Méthode pour afficher le formulaire de modification
    public function edit($id)
    {
        $client = Client::findOrFail($id);  // Trouver le client par son ID
        return view('admin.pages.clients.edit', compact('client'));
    }

    // Méthode pour mettre à jour le client
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);  // Trouver le client par son ID

        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'tel' => 'required|string|max:15',
            'adresse' => 'nullable|string',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
        ]);

        // Mise à jour du client
        $client->update($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

}
