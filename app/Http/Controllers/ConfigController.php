<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class ConfigController extends Controller
{
    public function company()
    {
        $company = Company::first(); // Load the first record from the companies table
        return view('admin.pages.config.company', compact('company'));
    }

    public function updateCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'social_networks' => 'nullable|json',
            'tax_info' => 'nullable|string|max:1000',
            'horaires' => 'nullable|string|max:500',
            'saison' => 'nullable|string|max:255', // Added validation for saison
            'note' => 'nullable|string|max:1000',  // Added validation for note
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Ensure the Company model exists before using it
        if (class_exists(Company::class)) {
            $company = Company::first(); // Assuming a single company record
            if ($company) {
                $company->update($validated);
            } else {
                Company::create($validated);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Le modèle Company n\'existe pas.']);
        }

        return redirect()->route('company.update')->with('success', 'Informations de la société mises à jour avec succès.');
    }
}
