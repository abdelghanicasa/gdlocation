<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $promo = new PromoCode();
        return view('admin.promos.create', compact('promo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code',
            'discount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'active' => 'nullable|boolean',
        ]);
    
        PromoCode::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'expires_at' => $request->expires_at,
            'usage_limit' => $request->usage_limit,
            'active' => $request->has('active'),
        ]);
    
        return redirect()->route('promos.index')->with('success', 'Code promo créé avec succès.');
    }
    

    public function edit(PromoCode $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, PromoCode $promo)
    {
        // dd($request->all());
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $promo->id,
            'discount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'active' => 'nullable|boolean',
        ]);
    
        $promo->update([
            'code' => $request->code,
            'discount' => $request->discount,
            'expires_at' => $request->expires_at,
            'usage_limit' => $request->usage_limit,
            'active' => $request->active,
        ]);
    
        return redirect()->route('promos.index')->with('success', 'Code promo mis à jour avec succès.');
    }
    

    public function destroy(PromoCode $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Code promo supprimé.');
    }

    public function verify(Request $request)
    {
        $code = $request->input('code');
        $promo = PromoCode::where('code', $code)->where('active', 1)->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Code invalide.'], 404);
        }

        if ($promo->expires_at && $promo->expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'Ce code a expiré.'], 400);
        }

        if ($promo->usage_limit !== null && $promo->uses >= $promo->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Ce code a atteint sa limite.'], 400);
        }

        return response()->json([
            'success' => true,
            'discount' => $promo->discount,
            'type' => $promo->discount_type, // 'amount' ou 'percent'
        ]);
    }
}

