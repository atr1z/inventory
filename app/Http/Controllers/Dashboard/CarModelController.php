<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarModelController extends Controller
{
    /**
     * Display a listing of the car models.
     */
    public function index()
    {
        $carModels = CarModel::with('carBrand')->withCount('autoParts')->get();
        return view('dashboard.car-models.index', compact('carModels'));
    }

    /**
     * Show the form for creating a new car model.
     */
    public function create()
    {
        $carBrands = CarBrand::all();
        return view('dashboard.car-models.create', compact('carBrands'));
    }

    /**
     * Store a newly created car model in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // 1MB max
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('car_models', 'public');
        }

        CarModel::create($validated);

        return redirect()->route('car-models.index')
            ->with('success', 'Modelo de auto creado correctamente.');
    }

    /**
     * Display the specified car model.
     */
    public function show(CarModel $carModel)
    {
        $carModel->load('autoParts');
        return view('dashboard.car-models.show', compact('carModel'));
    }

    /**
     * Show the form for editing the specified car model.
     */
    public function edit(CarModel $carModel)
    {
        $carBrands = CarBrand::all();
        return view('dashboard.car-models.edit', compact('carModel', 'carBrands'));
    }

    /**
     * Update the specified car model in storage.
     */
    public function update(Request $request, CarModel $carModel)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // 1MB max
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($carModel->image) {
                Storage::disk('public')->delete($carModel->image);
            }
            $validated['image'] = $request->file('image')->store('car_models', 'public');
        }

        $carModel->update($validated);

        return redirect()->route('car-models.index')
            ->with('success', 'Modelo de auto actualizado correctamente.');
    }

    /**
     * Remove the specified car model from storage.
     */
    public function destroy(CarModel $carModel)
    {
        // Check if there are auto parts associated with this car model
        if ($carModel->autoParts()->count() > 0) {
            return redirect()->route('car-models.index')
                ->with('error', 'No se puede eliminar este modelo porque tiene autopartes asociadas.');
        }

        // Delete image if it exists
        if ($carModel->image) {
            Storage::disk('public')->delete($carModel->image);
        }

        $carModel->delete();

        return redirect()->route('car-models.index')
            ->with('success', 'Modelo de auto eliminado correctamente.');
    }
}
