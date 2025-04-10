<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\AutoPart;
use App\Models\CarModel;

class FileController extends Controller
{
    /**
     * Constructor to ensure all methods require authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Serve an auto part image securely
     */
    public function getAutoPartImage($id)
    {
        $autoPart = AutoPart::findOrFail($id);
        
        // Check if image exists
        if (!$autoPart->image) {
            abort(404);
        }
        
        // First check if the image exists in the private storage
        if (Storage::exists($autoPart->image)) {
            return response()->file(Storage::path($autoPart->image));
        }
        
        // If not found in private storage, check public storage
        if (Storage::disk('public')->exists($autoPart->image)) {
            return response()->file(Storage::disk('public')->path($autoPart->image));
        }
        
        // Image not found in either location
        abort(404);
    }

    /**
     * Serve an auto part invoice securely
     */
    public function getAutoPartInvoice($id)
    {
        $autoPart = AutoPart::findOrFail($id);
        
        // Check if invoice exists
        if (!$autoPart->purchase_invoice) {
            abort(404);
        }
        
        // Additional authorization check - only managers can view invoices
        if (Auth::user()->role !== 'manager') {
            abort(403, 'Unauthorized action.');
        }
        
        // First check if the invoice exists in the private storage
        if (Storage::exists($autoPart->purchase_invoice)) {
            return response()->file(Storage::path($autoPart->purchase_invoice));
        }
        
        // If not found in private storage, check public storage
        if (Storage::disk('public')->exists($autoPart->purchase_invoice)) {
            return response()->file(Storage::disk('public')->path($autoPart->purchase_invoice));
        }
        
        // Invoice not found in either location
        abort(404);
    }

    /**
     * Serve a car model image securely
     */
    public function getCarModelImage($id)
    {
        $carModel = CarModel::findOrFail($id);
        
        // If no image path is stored, return 404
        if (!$carModel->image) {
            abort(404);
        }
        
        // Debug information - log what we're trying to serve
        \Log::info('Attempting to serve car model image', [
            'id' => $id,
            'stored_path' => $carModel->image
        ]);
        
        // Get the direct path to the file in storage/app
        $path = storage_path('app/private/' . $carModel->image);
        
        // Check if the file exists at the direct path
        if (file_exists($path)) {
            \Log::info('Found image at path', ['path' => $path]);
            
            // Make sure the file is readable
            if (!is_readable($path)) {
                // Try to fix permissions if possible
                chmod($path, 0644);
                chmod(dirname($path), 0755);
                
                if (!is_readable($path)) {
                    \Log::error('File exists but is not readable', ['path' => $path]);
                    abort(403, 'File exists but is not readable');
                }
            }
            
            return response()->file($path);
        }
        
        // If not found at the direct path, try other possible locations
        $alternativePaths = [
            // Check in storage/app
            storage_path('app/' . $carModel->image),
            
            // Check in storage/app/public
            storage_path('app/public/' . $carModel->image),
            
            // Check in public/storage
            public_path('storage/' . $carModel->image)
        ];
        
        foreach ($alternativePaths as $altPath) {
            if (file_exists($altPath) && is_readable($altPath)) {
                \Log::info('Found image at alternative path', ['path' => $altPath]);
                return response()->file($altPath);
            }
        }
        
        // Log that the image was not found
        \Log::warning('Car model image not found', [
            'id' => $id,
            'stored_path' => $carModel->image,
            'checked_paths' => array_merge([$path], $alternativePaths)
        ]);
        
        // Image not found in any location
        abort(404);
    }
}
