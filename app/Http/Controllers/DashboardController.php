<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'All');

        $query = Meal::query();

        // Only filter by today if there are records today, otherwise show all
        $todayCount = Meal::whereDate('served_at', today())->count();
        if ($todayCount > 0) {
            $query->whereDate('served_at', today());
        }

        if ($filter !== 'All') {
            $query->where('meal_type', $filter);
        }

        $meals = $query->latest('served_at')->paginate(15);

        $base = Meal::whereDate('served_at', today());

        return view('dashboard', [
            'meals'          => $meals,
            'filter'         => $filter,
            'totalMeals'     => (clone $base)->count(),
            'breakfastCount' => (clone $base)->where('meal_type', 'Breakfast')->count(),
            'lunchCount'     => (clone $base)->where('meal_type', 'Lunch')->count(),
            'dinnerCount'    => (clone $base)->where('meal_type', 'Dinner')->count(),
        ]);
    }
}