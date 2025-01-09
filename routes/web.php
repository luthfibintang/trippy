<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TSPController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CRUDController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/buatperjalanan', function () {
    return Inertia::render('BuatPerjalanan');
})->middleware(['auth', 'verified'])->name('buatPerjalanan');

Route::get('/reviewperjalanan', function () {
    return Inertia::render('ReviewPerjalanan');
})->middleware(['auth', 'verified'])->name('reviewPerjalanan');

Route::get('/detailperjalanan', function () {
    return Inertia::render('DetailPerjalanan');
})->middleware(['auth', 'verified'])->name('detailPerjalanan');

Route::get('/api/trips', function () {
    return response()->json([
        [
            'id' => 1,
            'namaTempat' => 'Bali Trip',
            'startDate' => '12 Jan',
            'tripUrl' => '/trips/1',
        ],
        [
            'id' => 2,
            'namaTempat' => 'Lombok Adventure',
            'startDate' => '20 Feb',
            'tripUrl' => '/trips/2',
        ],
        [
            'id' => 3,
            'namaTempat' => 'Jakarta Getaway',
            'startDate' => '5 Mar',
            'tripUrl' => '/trips/3',
        ],
    ]);
});

Route::post('/generateroute', [TSPController::class, 'getOptimizedRoute']);
Route::post('/create-itinerary', [CRUDController::class, 'create'])->middleware('auth');
Route::get('/get-itinerary/{id}', [CRUDController::class, 'read'])->middleware('auth');
Route::get('/delete-itinerary/{id}', [CRUDController::class, 'delete'])->middleware('auth');
Route::post('/update-itinerary/{id}', [CRUDController::class, 'update'])->middleware('auth');
Route::get('/getAll-Itinerary', [CRUDController::class, 'getAll'])->middleware('auth');

require __DIR__ . '/auth.php';
