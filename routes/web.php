<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\MealController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;



/*
|--------------------------------------------------------------------------
| Inmate Food Management System — Web Routes
|--------------------------------------------------------------------------
*/

// Protect all routes with auth middleware
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [MealController::class, 'dashboard'])->name('dashboard');

    // Meals (resource routes)
    Route::get('/meals',              [MealController::class, 'index']  )->name('meals.index');
    Route::get('/meals/create',       [MealController::class, 'create'] )->name('meals.create');
    Route::post('/meals',             [MealController::class, 'store']  )->name('meals.store');
    Route::get('/meals/{meal}/edit',  [MealController::class, 'edit']   )->name('meals.edit');
    Route::put('/meals/{meal}',       [MealController::class, 'update'] )->name('meals.update');
    Route::delete('/meals/{meal}',    [MealController::class, 'destroy'])->name('meals.destroy');

    // Ingredients
    Route::get('/ingredients',                   [IngredientController::class, 'index']  )->name('ingredients.index');
    Route::put('/ingredients/{ingredient}',      [IngredientController::class, 'update'] )->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}',   [IngredientController::class, 'destroy'])->name('ingredients.destroy');

    // Profile
    Route::get('/profile',          [ProfileController::class, 'index']         )->name('profile');
    Route::put('/profile',          [ProfileController::class, 'update']        )->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

});

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ]);
});

// Logout
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->name('logout'); 

require __DIR__.'/auth.php';