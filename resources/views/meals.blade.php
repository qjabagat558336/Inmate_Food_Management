<!-- resources/views/meals.blade.php -->

<x-app-layout>
    <x-slot name="header">
        Add Meal
    </x-slot>

    <h2 style="margin-bottom:20px;">Add New Meal</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('meals.store') }}" style="display:flex; flex-direction:column; gap:15px; max-width:500px;">
        @csrf

        <div>
            <label>Meal Name</label><br>
            <input type="text" name="meal_name" required
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div>
            <label>Meal Type</label><br>
            <select name="meal_type" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px;">
                <option value="">Select Meal Type</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
            </select>
        </div>

        <div>
            <label>Date</label><br>
            <input type="date" name="meal_date" required
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div>
            <label>Ingredients</label><br>
            <textarea name="ingredients" required
                      style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px; height:100px;"></textarea>
        </div>

        <button type="submit"
                style="padding:12px; background:#2563eb; color:white; border:none; border-radius:8px; cursor:pointer;">
            Save Meal
        </button>
    </form>
</x-app-layout>