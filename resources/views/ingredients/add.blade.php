<x-app-layout>
<div class="max-w-lg mx-auto mt-6 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">
        Add Ingredient to {{ $meal->meal_name }}
    </h2>

    <form method="POST" action="{{ route('ingredients.store', $meal->id) }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="w-full border p-2 rounded" required>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
</div>
</x-app-layout>