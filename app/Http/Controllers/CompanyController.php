<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'horaires' => 'nullable|string',
            'saison' => 'nullable|string',
            'note' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'social_networks' => 'nullable|json',
        ]);

        $company = Company::first();
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'horaires' => $request->horaires,
            'saison' => $request->saison,
            'note' => $request->note,
            'social_networks' => $request->social_networks ? json_encode(json_decode($request->social_networks, true)) : null,
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $company->update(['logo' => $path]);
        }

        return redirect()->back()->with('success', 'Informations de la société mises à jour avec succès.');
    }
}