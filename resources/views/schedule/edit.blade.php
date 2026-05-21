@extends('layouts.app')

@php $title = 'Edit Schedule'; @endphp

@section('topbar-actions')
    <a href="{{ route('schedule.index') }}" class="btn-secondary">← Back to schedule</a>
@endsection

@section('content')

    <div class="form-card">
        <form method="POST" action="{{ route('schedule.update', $schedule) }}">
            @csrf
            @method('PUT')

            <div class="form-row-2">
                <div>
                    <label class="form-label" for="meal_type">Meal Type</label>
                    <select class="form-select" id="meal_type" name="meal_type" required>
                        @foreach(['Breakfast','Lunch','Dinner','Special diet'] as $type)
                            <option value="{{ $type }}"
                                {{ old('meal_type', $schedule->meal_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('meal_type')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="menu_item">Menu Item</label>
                    <input class="form-input" type="text" id="menu_item" name="menu_item"
                           value="{{ old('menu_item', $schedule->menu_item) }}" required>
                    @error('menu_item')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row-2">
                <div>
                    <label class="form-label" for="start_time">Start Time</label>
                    <input class="form-input" type="time" id="start_time" name="start_time"
                           value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required>
                    @error('start_time')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="end_time">End Time</label>
                    <input class="form-input" type="time" id="end_time" name="end_time"
                           value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required>
                    @error('end_time')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <label class="form-label" for="blocks">Blocks</label>
                <input class="form-input" type="text" id="blocks" name="blocks"
                       value="{{ old('blocks', $schedule->blocks) }}" required>
                @error('blocks')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <label class="form-label" for="schedule_date">Schedule Date</label>
                <input class="form-input" type="date" id="schedule_date" name="schedule_date"
                       value="{{ old('schedule_date', $schedule->schedule_date) }}" required>
                @error('schedule_date')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('schedule.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update schedule</button>
            </div>
        </form>
    </div>

@endsection