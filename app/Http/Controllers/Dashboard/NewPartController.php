<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AutoPart;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewPartController extends Controller
{
    /**
     * Show the form for creating a new auto part.
     */
    public function create()
    {
        $carBrands = CarBrand::with('carModels')->get();
        $carModels = CarModel::with('carBrand')->get();
        return view('dashboard.new-part', compact('carBrands', 'carModels'));
    }

    /**
     * Store a newly created auto part in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'car_brand_id' => 'required|exists:car_brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'provider' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // 1MB max
            'purchase_invoice' => 'nullable|file|mimes:pdf|max:1024', // 1MB max
        ]);
        
        // Set in_stock flag based on quantity
        $validated['in_stock'] = $validated['quantity'] > 0;

        // Handle file uploads
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('auto_parts/images', 'public');
        }

        if ($request->hasFile('purchase_invoice')) {
            $validated['purchase_invoice'] = $request->file('purchase_invoice')->store('auto_parts/invoices', 'public');
        }

        AutoPart::create($validated);

        return redirect()->route('dashboard.parts')
            ->with('success', 'Autoparte creada correctamente.');
    }

    /**
     * Show the form for editing the specified auto part.
     */
    public function edit(AutoPart $autoPart)
    {
        $carBrands = CarBrand::with('carModels')->get();
        $carModels = CarModel::with('carBrand')->get();
        return view('dashboard.parts.edit', compact('autoPart', 'carBrands', 'carModels'));
    }

    /**
     * Update the specified auto part in storage.
     */
    public function update(Request $request, AutoPart $autoPart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'car_brand_id' => 'required|exists:car_brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'provider' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // 1MB max
            'purchase_invoice' => 'nullable|file|mimes:pdf|max:1024', // 1MB max
        ]);
        
        // Set in_stock flag based on quantity
        $validated['in_stock'] = $validated['quantity'] > 0;

        // Handle file uploads
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($autoPart->image) {
                Storage::disk('public')->delete($autoPart->image);
            }
            $validated['image'] = $request->file('image')->store('auto_parts/images', 'public');
        }

        if ($request->hasFile('purchase_invoice')) {
            // Delete old invoice if it exists
            if ($autoPart->purchase_invoice) {
                Storage::disk('public')->delete($autoPart->purchase_invoice);
            }
            $validated['purchase_invoice'] = $request->file('purchase_invoice')->store('auto_parts/invoices', 'public');
        }

        $autoPart->update($validated);

        return redirect()->route('dashboard.parts')
            ->with('success', 'Autoparte actualizada correctamente.');
    }

    /**
     * Remove the specified auto part from storage.
     */
    public function destroy(AutoPart $autoPart)
    {
        // Delete associated files
        if ($autoPart->image) {
            Storage::disk('public')->delete($autoPart->image);
        }
        if ($autoPart->purchase_invoice) {
            Storage::disk('public')->delete($autoPart->purchase_invoice);
        }

        $autoPart->delete();

        return redirect()->route('dashboard.parts')
            ->with('success', 'Autoparte eliminada correctamente.');
    }
}