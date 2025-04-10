<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SingInController;
use App\Http\Controllers\Dashboard\PartsListController;
use App\Http\Controllers\Dashboard\NewPartController;
use App\Http\Controllers\Dashboard\CarModelController;
use App\Http\Controllers\Dashboard\CarBrandController;
use App\Http\Middleware\EnsureUserIsManager;

// Redirect based on authentication status
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->action([PartsListController::class, 'index']);
    }
    return redirect()->action([SingInController::class, 'index']);
});

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::get('/sign-in', [SingInController::class, 'index'])->name('auth.sign-in');
    Route::post('/sign-in', [SingInController::class, 'signIn'])->name('auth.sign-in.post');
    Route::post('/sign-out', [SingInController::class, 'signOut'])->name('auth.sign-out');
});

// Add a login route alias for Laravel's default auth redirects
Route::get('/login', function() {
    return redirect()->route('auth.sign-in');
})->name('login');

// Protected routes requiring authentication
// This middleware will redirect any unauthenticated users to the login page
Route::middleware(['auth'])->group(function () {
    // All files now use public storage

    // Dashboard routes accessible by both roles
    Route::prefix('dashboard')->group(function () {
        Route::get('/parts', [PartsListController::class, 'index'])->name('dashboard.parts');
        
        // Routes for updating part quantities (accessible by both roles)
        Route::put('/parts/{autoPart}/quantity', [PartsListController::class, 'updateQuantity'])->name('dashboard.parts.update-quantity');
        
        // Manager-only routes
        Route::middleware([EnsureUserIsManager::class])->group(function () {
            Route::get('/parts/new', [NewPartController::class, 'create'])->name('dashboard.parts.new');
            Route::post('/parts', [NewPartController::class, 'store'])->name('dashboard.parts.store');
            Route::get('/parts/{autoPart}/edit', [NewPartController::class, 'edit'])->name('dashboard.parts.edit');
            Route::put('/parts/{autoPart}', [NewPartController::class, 'update'])->name('dashboard.parts.update');
            Route::delete('/parts/{autoPart}', [NewPartController::class, 'destroy'])->name('dashboard.parts.destroy');
            
            // Car models management (manager only)
            Route::resource('car-models', CarModelController::class);
            
            // Car brands management (manager only)
            Route::resource('car-brands', CarBrandController::class);
        });
    });
});

// Fallback route for any unauthorized access attempts
Route::fallback(function () {
    if (!auth()->check()) {
        return redirect()->route('auth.sign-in');
    }
    
    return redirect()->route('dashboard.parts');
});
