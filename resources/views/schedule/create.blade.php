@extends('layouts.app')

@php $title = 'Add Schedule'; @endphp

@section('topbar-actions')
    <a href="{{ route('schedule.index') }}" class="btn-secondary">← Back to schedule</a>
@endsection

@section('content')

    <div class="form-card">
        <form method="POST" action="{{ route('schedule.store') }}">
            @csrf

            <div class="form-row-2">
                <div>
                    <label class="form-label" for="meal_type">Meal Type</label>
                    <select class="form-select" id="meal_type" name="meal_type" required>
                        <option value="">Select type</option>
                        @foreach(['Breakfast','Lunch','Dinner','Special diet'] as $type)
                            <option value="{{ $type }}" {{ old('meal_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('meal_type')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="menu_item">Menu Item</label>
                    <input class="form-input" type="text" id="menu_item" name="menu_item"
                           placeholder="e.g. Rice & chicken" value="{{ old('menu_item') }}" required>
                    @error('menu_item')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row-2">
                <div>
                    <label class="form-label" for="start_time">Start Time</label>
                    <input class="form-input" type="time" id="start_time" name="start_time"
                           value="{{ old('start_time', '06:30') }}" required>
                    @error('start_time')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="end_time">End Time</label>
                    <input class="form-input" type="time" id="end_time" name="end_time"
                           value="{{ old('end_time', '07:30') }}" required>
                    @error('end_time')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <label class="form-label" for="blocks">Blocks</label>
                <input class="form-input" type="text" id="blocks" name="blocks"
                       placeholder="e.g. Block A, Block B" value="{{ old('blocks') }}" required>
                @error('blocks')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <label class="form-label" for="schedule_date">Schedule Date</label>
                <input class="form-input" type="date" id="schedule_date" name="schedule_date"
                       value="{{ old('schedule_date', now()->toDateString()) }}" required>
                @error('schedule_date')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('schedule.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save schedule</button>
            </div>
        </form>
    </div>

@endsection