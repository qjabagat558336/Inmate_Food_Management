<x-app-layout>

    <div class="max-w-4xl mx-auto py-10 px-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Add Ingredient</h1>
                <p class="text-gray-500">Create a meal and list its ingredients</p>
            </div>

            <a href="{{ route('ingredients.index') }}"
               class="px-5 py-3 bg-gray-200 rounded-2xl hover:bg-gray-300 font-semibold">
                ← Back
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-3xl p-10">

            <form method="POST" action="{{ route('ingredients.store') }}">
                @csrf

                <!-- Meal Name -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Meal Name
                    </label>

                    <input
                        type="text"
                        name="meal_name"
                        value="{{ old('meal_name') }}"
                        placeholder="e.g. Adobo"
                        required
                        class="w-full rounded-2xl border-gray-300 px-4 py-3"
                    >

                    @error('meal_name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ingredient Name -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ingredient Name
                    </label>

                    <input
                        type="text"
                        name="ingredient_name"
                        value="{{ old('ingredient_name') }}"
                        placeholder="e.g. Chicken"
                        required
                        class="w-full rounded-2xl border-gray-300 px-4 py-3"
                    >

                    @error('ingredient_name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity + Unit + Price -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Quantity
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            placeholder="1"
                            required
                            class="w-full rounded-2xl border-gray-300 px-4 py-3"
                        >
                    </div>

                    <!-- Unit -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Unit
                        </label>

                        <select
                            name="unit"
                            required
                            class="w-full rounded-2xl border-gray-300 px-4 py-3"
                        >
                            <option value="">Select Unit</option>

                            @foreach(['kg', 'g', 'L', 'ml', 'pcs', 'tbsp', 'tsp', 'cups'] as $unit)
                                <option value="{{ $unit }}">
                                    {{ $unit }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Price (₱)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="0.00"
                            required
                            class="w-full rounded-2xl border-gray-300 px-4 py-3"
                        >
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('ingredients.index') }}"
                       class="px-6 py-3 bg-gray-200 rounded-2xl hover:bg-gray-300 font-semibold">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-semibold"
                    >
                        Save Ingredient
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>