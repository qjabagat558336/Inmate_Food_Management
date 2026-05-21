<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meal Schedule') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Meal schedule</h1>
                    <p class="text-sm text-gray-400 mt-0.5">All meal records across all dates</p>
                </div>
                <a href="{{ route('meals.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-teal-800 text-teal-100 text-sm font-medium rounded-lg hover:bg-teal-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add meal
                </a>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide px-4 py-3">Date</th>
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
                                <td class="px-4 py-3 text-xs text-gray-400">
                                    {{ $meal->served_date->format('M j, Y') }}
                                </td>
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
                                        <button type="submit" class="text-xs text-gray-300 hover:text-red-500 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-sm text-gray-400">
                                    No meal records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($meals->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $meals->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>