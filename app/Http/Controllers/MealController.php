<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MealController extends Controller
{
    // Shared meal type options — single source of truth
    const MEAL_TYPES = ['Breakfast', 'Brunch', 'Lunch', 'Merienda', 'Dinner', 'Snack', 'Dessert', 'Drinks'];

    public function dashboard()
    {
        $totalMeals       = Meal::count();
        $totalIngredients = Ingredient::count();
        $today            = Carbon::now()->format('l');
        $todayMeals       = Meal::where('day', $today)->count();
        $recentMeals      = Meal::latest()->take(5)->get();

        $days     = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $schedule = [];
        $allMeals = Meal::all()->groupBy('day');
        foreach ($days as $day) {
            $schedule[$day] = $allMeals[$day] ?? collect();
        }

        return view('dashboard', compact(
            'totalMeals', 'totalIngredients', 'todayMeals', 'recentMeals', 'schedule'
        ));
    }

    public function index(Request $request)
    {
        $query = Meal::with('ingredients')->latest();

        if ($request->filled('search')) {
            $query->where('meal_name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }
        if ($request->filled('meal_type')) {
            $query->where('meal_type', $request->meal_type);
        }

        $meals     = $query->paginate(15);
        $mealTypes = self::MEAL_TYPES;

        return view('meals.index', compact('meals', 'mealTypes'));
    }

    public function create()
    {
        $mealTypes = self::MEAL_TYPES;
        return view('meals.create', compact('mealTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_name'                    => 'required|string|max:255',
            'meal_type'                    => 'nullable|in:' . implode(',', self::MEAL_TYPES),
            'day'                          => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'quantity'                     => 'required|numeric|min:0',
            'unit'                         => 'required|string|max:50',
            'ingredients'                  => 'nullable|array',
            'ingredients.*.name'           => 'nullable|string|max:255',
            'ingredients.*.quantity'       => 'nullable|numeric|min:0',
            'ingredients.*.unit'           => 'nullable|string|max:50',
            'ingredients.*.price_per_unit' => 'nullable|numeric|min:0',
        ]);

        $mealTotal = 0;
        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ing) {
                if (!empty($ing['name'])) {
                    $mealTotal += ($ing['quantity'] ?? 0) * ($ing['price_per_unit'] ?? 0);
                }
            }
        }

        $meal = Meal::create([
            'meal_name' => $validated['meal_name'],
            'meal_type' => $validated['meal_type'] ?? null,
            'day'       => $validated['day'],
            'quantity'  => $validated['quantity'],
            'unit'      => $validated['unit'],
            'price'     => $mealTotal,
        ]);

        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ing) {
                if (!empty($ing['name'])) {
                    $qty          = $ing['quantity']       ?? 0;
                    $pricePerUnit = $ing['price_per_unit'] ?? 0;
                    $meal->ingredients()->create([
                        'name'           => $ing['name'],
                        'quantity'       => $qty,
                        'unit'           => $ing['unit'] ?? null,
                        'price_per_unit' => $pricePerUnit,
                        'price'          => $qty * $pricePerUnit,
                    ]);
                }
            }
        }

        return redirect()->route('meals.index')
            ->with('success', "Meal \"{$meal->meal_name}\" has been saved successfully.");
    }

    public function edit(Meal $meal)
    {
        $meal->load('ingredients');
        $mealTypes = self::MEAL_TYPES;
        return view('meals.edit', compact('meal', 'mealTypes'));
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'meal_name'                    => 'required|string|max:255',
            'meal_type'                    => 'nullable|in:' . implode(',', self::MEAL_TYPES),
            'day'                          => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'quantity'                     => 'required|numeric|min:0',
            'unit'                         => 'required|string|max:50',
            'ingredients'                  => 'nullable|array',
            'ingredients.*.id'             => 'nullable|integer',
            'ingredients.*.name'           => 'nullable|string|max:255',
            'ingredients.*.quantity'       => 'nullable|numeric|min:0',
            'ingredients.*.unit'           => 'nullable|string|max:50',
            'ingredients.*.price_per_unit' => 'nullable|numeric|min:0',
        ]);

        $mealTotal = 0;
        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ing) {
                if (!empty($ing['name'])) {
                    $mealTotal += ($ing['quantity'] ?? 0) * ($ing['price_per_unit'] ?? 0);
                }
            }
        }

        $meal->update([
            'meal_name' => $validated['meal_name'],
            'meal_type' => $validated['meal_type'] ?? null,
            'day'       => $validated['day'],
            'quantity'  => $validated['quantity'],
            'unit'      => $validated['unit'],
            'price'     => $mealTotal,
        ]);

        $meal->ingredients()->delete();

        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ing) {
                if (!empty($ing['name'])) {
                    $qty          = $ing['quantity']       ?? 0;
                    $pricePerUnit = $ing['price_per_unit'] ?? 0;
                    $meal->ingredients()->create([
                        'name'           => $ing['name'],
                        'quantity'       => $qty,
                        'unit'           => $ing['unit'] ?? null,
                        'price_per_unit' => $pricePerUnit,
                        'price'          => $qty * $pricePerUnit,
                    ]);
                }
            }
        }

        return redirect()->route('meals.index')
            ->with('success', "Meal \"{$meal->meal_name}\" has been updated successfully.");
    }

    public function destroy(Meal $meal)
    {
        $name = $meal->meal_name;
        $meal->ingredients()->delete();
        $meal->delete();

        return back()->with('success', "Meal \"{$name}\" has been deleted.");
    }
}