<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Meal') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h1 class="text-lg font-semibold text-gray-900 mb-6">New meal record</h1>

                <form method="POST" action="{{ route('meals.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="redirect" value="meals.create"/>

                    {{-- Inmate --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Inmate</label>
                        <select name="inmate_id" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('inmate_id') border-red-400 @enderror">
                            <option value="">Select inmate...</option>
                            @foreach ($inmates as $inmate)
                                <option value="{{ $inmate->id }}" {{ old('inmate_id') == $inmate->id ? 'selected' : '' }}>
                                    {{ $inmate->inmate_number }} — {{ $inmate->name }} ({{ $inmate->block }})
                                </option>
                            @endforeach
                        </select>
                        @error('inmate_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Meal type --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Meal type</label>
                        <select name="meal_type" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach (['Breakfast', 'Lunch', 'Dinner', 'Special diet'] as $type)
                                <option value="{{ $type }}" {{ old('meal_type') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Menu item --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Menu item</label>
                        <input type="text" name="menu_item" value="{{ old('menu_item') }}"
                            placeholder="e.g. Rice and beans" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_item') border-red-400 @enderror"/>
                        @error('menu_item')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date & Time --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Date</label>
                            <input type="date" name="served_date" required
                                value="{{ old('served_date', now()->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Time</label>
                            <input type="time" name="served_time"
                                value="{{ old('served_time', now()->format('H:i')) }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"/>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Status</label>
                        <select name="status" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="Served">Served</option>
                            <option value="Pending">Pending</option>
                            <option value="Skipped">Skipped</option>
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('dashboard') }}"
                            class="text-sm text-gray-400 hover:text-gray-600 transition">
                            ← Back to dashboard
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-800 text-teal-100 text-sm font-medium rounded-lg hover:bg-teal-700 transition">
                            Save meal record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>