@extends('layouts.app')

@php $title = 'Meal Schedule'; @endphp

@section('topbar-actions')
    <a href="{{ route('schedule.create') }}" class="btn-primary">+ Add schedule</a>
@endsection

@section('content')

    <div class="schedule-grid">
        {{-- Breakfast column --}}
        <div class="sched-col">
            <div class="sched-header b">Breakfast · Morning</div>
            @forelse($schedules->where('meal_type','Breakfast') as $item)
                <div class="sched-item">
                    <div class="sched-time">
                        {{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }}
                        – {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}
                    </div>
                    <div class="sched-meal">{{ $item->menu_item }}</div>
                    <div class="sched-block">{{ $item->blocks }}</div>
                    <div class="sched-actions">
                        <a href="{{ route('schedule.edit', $item) }}" class="action-link edit" style="font-size:11px;">Edit</a>
                        <form method="POST" action="{{ route('schedule.destroy', $item) }}"
                              onsubmit="return confirm('Delete this schedule?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-link"
                                    style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:11px;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sched-item" style="color:#9CA3AF;font-size:12px;">No breakfast scheduled.</div>
            @endforelse
        </div>

        {{-- Lunch column --}}
        <div class="sched-col">
            <div class="sched-header l">Lunch · Midday</div>
            @forelse($schedules->where('meal_type','Lunch') as $item)
                <div class="sched-item">
                    <div class="sched-time">
                        {{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }}
                        – {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}
                    </div>
                    <div class="sched-meal">{{ $item->menu_item }}</div>
                    <div class="sched-block">{{ $item->blocks }}</div>
                    <div class="sched-actions">
                        <a href="{{ route('schedule.edit', $item) }}" class="action-link edit" style="font-size:11px;">Edit</a>
                        <form method="POST" action="{{ route('schedule.destroy', $item) }}"
                              onsubmit="return confirm('Delete this schedule?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-link"
                                    style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:11px;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sched-item" style="color:#9CA3AF;font-size:12px;">No lunch scheduled.</div>
            @endforelse
        </div>

        {{-- Dinner column --}}
        <div class="sched-col">
            <div class="sched-header d">Dinner · Evening</div>
            @forelse($schedules->where('meal_type','Dinner') as $item)
                <div class="sched-item">
                    <div class="sched-time">
                        {{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }}
                        – {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}
                    </div>
                    <div class="sched-meal">{{ $item->menu_item }}</div>
                    <div class="sched-block">{{ $item->blocks }}</div>
                    <div class="sched-actions">
                        <a href="{{ route('schedule.edit', $item) }}" class="action-link edit" style="font-size:11px;">Edit</a>
                        <form method="POST" action="{{ route('schedule.destroy', $item) }}"
                              onsubmit="return confirm('Delete this schedule?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-link"
                                    style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:11px;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sched-item" style="color:#9CA3AF;font-size:12px;">No dinner scheduled.</div>
            @endforelse
        </div>
    </div>

@endsection