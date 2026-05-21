<x-app-layout>
    <x-slot name="header">
        Ingredients
    </x-slot>

    <h2>Ingredients List</h2>

    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <tr style="background:#f3f4f6;">
            <th style="padding:10px; border:1px solid #ddd;">Ingredient</th>
            <th style="padding:10px; border:1px solid #ddd;">Quantity</th>
        </tr>
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">Rice</td>
            <td style="padding:10px; border:1px solid #ddd;">50 kg</td>
        </tr>
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">Chicken</td>
            <td style="padding:10px; border:1px solid #ddd;">30 kg</td>
        </tr>
    </table>
</x-app-layout>