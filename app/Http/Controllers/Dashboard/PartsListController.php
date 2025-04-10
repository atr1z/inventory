<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AutoPart;
use Illuminate\Http\Request;

class PartsListController extends Controller
{
    /**
     * Display a listing of all auto parts.
     */
    public function index()
    {
        $autoParts = AutoPart::with(['carBrand', 'carModel'])->get();
        return view('dashboard.parts-list', compact('autoParts'));
    }

    /**
     * Update the quantity of an auto part.
     * This method is accessible by both Encargado and Vendedor roles.
     */
    public function updateQuantity(Request $request, AutoPart $autoPart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $autoPart->quantity = $request->quantity;
        $autoPart->save();

        return redirect()->route('dashboard.parts')
            ->with('success', 'Cantidad actualizada correctamente.');
    }
}
