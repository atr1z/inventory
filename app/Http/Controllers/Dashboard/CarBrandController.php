<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    /**
     * Display a listing of the car brands.
     */
    public function index()
    {
        $carBrands = CarBrand::withCount('carModels')->get();
        return view('dashboard.car-brands.index', compact('carBrands'));
    }

    /**
     * Show the form for creating a new car brand.
     */
    public function create()
    {
        return view('dashboard.car-brands.create');
    }

    /**
     * Store a newly created car brand in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands',
        ]);

        CarBrand::create($validated);

        return redirect()->route('car-brands.index')
            ->with('success', 'Marca de auto creada correctamente.');
    }

    /**
     * Display the specified car brand.
     */
    public function show(CarBrand $carBrand)
    {
        $carBrand->load('carModels');
        return view('dashboard.car-brands.show', compact('carBrand'));
    }

    /**
     * Show the form for editing the specified car brand.
     */
    public function edit(CarBrand $carBrand)
    {
        return view('dashboard.car-brands.edit', compact('carBrand'));
    }

    /**
     * Update the specified car brand in storage.
     */
    public function update(Request $request, CarBrand $carBrand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands,name,' . $carBrand->id,
        ]);

        $carBrand->update($validated);

        return redirect()->route('car-brands.index')
            ->with('success', 'Marca de auto actualizada correctamente.');
    }

    /**
     * Remove the specified car brand from storage.
     */
    public function destroy(CarBrand $carBrand)
    {
        // Check if there are car models associated with this car brand
        if ($carBrand->carModels()->count() > 0) {
            return redirect()->route('car-brands.index')
                ->with('error', 'No se puede eliminar esta marca porque tiene modelos asociados.');
        }

        $carBrand->delete();

        return redirect()->route('car-brands.index')
            ->with('success', 'Marca de auto eliminada correctamente.');
    }
}
