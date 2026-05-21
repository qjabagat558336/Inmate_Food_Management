<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meal Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Top bar --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Meal records</h1>
                    <p class="text-sm text-gray-400 mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
                <button onclick="document.getElementById('mealModal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-teal-800 text-teal-100 text-sm font-medium rounded-lg hover:bg-teal-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add meal
                </button>
            </div>

            {{-- Metric cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total meals today</p>
                    <p class="text-3xl font-semibold text-teal-800">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">across all blocks</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Breakfast</p>
                    <p class="text-3xl font-semibold text-amber-700">{{ $stats['breakfast'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">morning service</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Lunch</p>
                    <p class="text-3xl font-semibold text-teal-700">{{ $stats['lunch'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">midday service</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Dinner</p>
                    <p class="text-3xl font-semibold text-green-700">{{ $stats['dinner'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">evening service</p>
                </div>
            </div>

            {{-- Filter tabs --}}
            <div class="flex gap-2 mb-4">
                @foreach (['All', 'Breakfast', 'Lunch', 'Dinner'] as $type)
                    <a href="{{ route('dashboard', ['filter' => $type]) }}"
                        class="px-4 py-1.5 rounded-full text-sm border transition
                            {{ $filter === $type
                                ? 'bg-teal-50 border-teal-400 text-teal-800 font-medium'
                                : 'border-gray-200 text-gray-500 hover:bg-gray-50' }}">
                        {{ $type }}
                    </a>
                @endforeach
            </div>

            {{-- Meals table --}}
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Inmate ID</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Name</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Block</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Meal</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Menu item</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Time</th>
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($meals as $meal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-mono text-xs text-gray-400">
                                    {{ $meal->inmate->inmate_number }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $meal->inmate->name }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $meal->inmate->block }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $mealColors = [
                                            'Breakfast'    => 'bg-amber-50 text-amber-800',
                                            'Lunch'        => 'bg-teal-50 text-teal-800',
                                            'Dinner'       => 'bg-blue-50 text-blue-800',
                                            'Special diet' => 'bg-purple-50 text-purple-800',
                                        ];
                                        $color = $mealColors[$meal->meal_type] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ $meal->meal_type }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $meal->menu_item }}</td>
                                <td class="px-4 py-3 text-xs text-gray-400">
                                    {{ $meal->served_time ? \Carbon\Carbon::parse($meal->served_time)->format('h:i A') : '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($meal->status === 'Served')
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700">Served</span>
                                    @elseif ($meal->status === 'Pending')
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Pending</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600">Skipped</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form method="POST" action="{{ route('meals.destroy', $meal) }}"
                                        onsubmit="return confirm('Delete this meal record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-gray-300 hover:text-red-500 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-sm text-gray-400">
                                    No meal records found for today.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Add Meal Modal --}}
    <div id="mealModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-semibold text-gray-900">Add meal record</h2>
                <button onclick="document.getElementById('mealModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('meals.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Inmate</label>
                    <select name="inmate_id" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Select inmate...</option>
                        @foreach ($inmates as $inmate)
                            <option value="{{ $inmate->id }}">
                                {{ $inmate->inmate_number }} — {{ $inmate->name }} ({{ $inmate->block }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Meal type</label>
                    <select name="meal_type" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option>Breakfast</option>
                        <option>Lunch</option>
                        <option>Dinner</option>
                        <option>Special diet</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Menu item</label>
                    <input type="text" name="menu_item" required placeholder="e.g. Rice and beans"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"/>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Date</label>
                        <input type="date" name="served_date" required value="{{ now()->format('Y-m-d') }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Time</label>
                        <input type="time" name="served_time" value="{{ now()->format('H:i') }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"/>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="Served">Served</option>
                        <option value="Pending">Pending</option>
                        <option value="Skipped">Skipped</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button"
                        onclick="document.getElementById('mealModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium bg-teal-800 text-teal-100 rounded-lg hover:bg-teal-700 transition">
                        Save record
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>