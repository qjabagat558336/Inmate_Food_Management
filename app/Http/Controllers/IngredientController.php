<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Meal;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Show all ingredients grouped by meal
     */
    public function index(Request $request)
    {
        $query = Meal::with(['ingredients' => function ($q) use ($request) {
            if ($request->filled('search')) {
                $q->where('name', 'like', '%' . $request->search . '%');
            }
        }]);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('meal_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('ingredients', function ($iq) use ($request) {
                      $iq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $meals = $query->latest()->get();

        return view('ingredients.index', compact('meals'));
    }

    /**
     * Update a single ingredient inline
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            
            
        ]);

        $ingredient->update($validated);

        return back()->with('success', "Ingredient \"{$ingredient->name}\" updated.");
    }

    /**
     * Delete a single ingredient
     */
    public function destroy(Ingredient $ingredient)
    {
        $name = $ingredient->name;
        $ingredient->delete();

        return back()->with('success', "Ingredient \"{$name}\" has been removed.");
    }
}