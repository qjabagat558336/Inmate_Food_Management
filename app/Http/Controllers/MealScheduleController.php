<?php

namespace App\Http\Controllers;

use App\Models\MealSchedule;
use Illuminate\Http\Request;

class MealScheduleController extends Controller
{
    public function index()
    {
        $schedules = MealSchedule::whereDate('schedule_date', today())
                                 ->orderBy('start_time')
                                 ->get();

        return view('schedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedule.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_type'     => 'required|in:Breakfast,Lunch,Dinner,Special diet',
            'menu_item'     => 'required|string|max:100',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'blocks'        => 'required|string|max:100',
            'schedule_date' => 'required|date',
        ]);

        MealSchedule::create($validated);

        return redirect()->route('schedule.index')
                         ->with('success', 'Schedule added successfully.');
    }

    public function edit(MealSchedule $schedule)
    {
        return view('schedule.edit', compact('schedule'));
    }

    public function update(Request $request, MealSchedule $schedule)
    {
        $validated = $request->validate([
            'meal_type'     => 'required|in:Breakfast,Lunch,Dinner,Special diet',
            'menu_item'     => 'required|string|max:100',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'blocks'        => 'required|string|max:100',
            'schedule_date' => 'required|date',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedule.index')
                         ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(MealSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted.');
    }
}