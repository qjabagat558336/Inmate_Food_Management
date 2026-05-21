<!-- CREATE THIS FILE: resources/views/reports.blade.php -->

<x-app-layout>
    <x-slot name="header">
        Meal Reports
    </x-slot>

    <h2 style="margin-bottom:20px;">Meal Summary Report</h2>

    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin-bottom:30px;">

        <div style="background:#dbeafe; padding:20px; border-radius:10px; text-align:center;">
            <h3>Total Meals</h3>
            <p style="font-size:30px; font-weight:bold;">{{ count($meals) }}</p>
        </div>

        <div style="background:#dcfce7; padding:20px; border-radius:10px; text-align:center;">
            <h3>Breakfast</h3>
            <p style="font-size:30px; font-weight:bold;">
                {{ collect($meals)->where('meal_type', 'Breakfast')->count() }}
            </p>
        </div>

        <div style="background:#fef3c7; padding:20px; border-radius:10px; text-align:center;">
            <h3>Lunch & Dinner</h3>
            <p style="font-size:30px; font-weight:bold;">
                {{ collect($meals)->whereIn('meal_type', ['Lunch', 'Dinner'])->count() }}
            </p>
        </div>

    </div>

    <h3 style="margin-bottom:15px;">All Meal Records</h3>

    @if(count($meals) > 0)
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f4f6;">
                    <th style="padding:12px; border:1px solid #ddd;">Meal Name</th>
                    <th style="padding:12px; border:1px solid #ddd;">Meal Type</th>
                    <th style="padding:12px; border:1px solid #ddd;">Date</th>
                    <th style="padding:12px; border:1px solid #ddd;">Ingredients</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meals as $meal)
                    <tr>
                        <td style="padding:12px; border:1px solid #ddd;">{{ $meal['meal_name'] }}</td>
                        <td style="padding:12px; border:1px solid #ddd;">{{ $meal['meal_type'] }}</td>
                        <td style="padding:12px; border:1px solid #ddd;">{{ $meal['meal_date'] }}</td>
                        <td style="padding:12px; border:1px solid #ddd;">{{ $meal['ingredients'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No reports available yet.</p>
    @endif

</x-app-layout>