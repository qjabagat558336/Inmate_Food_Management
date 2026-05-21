@extends('layouts.app')
@section('title', 'Edit Meal')

@section('content')
<div class="page-header">
    <div>
        <h2>Edit Meal</h2>
        <p style="color:var(--muted);font-size:14px;margin-top:2px;">Editing: <strong>{{ $meal->meal_name }}</strong></p>
    </div>
    <a href="{{ route('meals.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Records
    </a>
</div>

<form method="POST" action="{{ route('meals.update', $meal->id) }}" id="meal-form">
    @csrf @method('PUT')

    <div class="card" style="margin-bottom:24px;">
        <div class="card-header"><h3>Meal Information</h3></div>
        <div class="card-body">

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Day <span style="color:var(--danger)">*</span></label>
                    <select name="day" class="form-control {{ $errors->has('day') ? 'is-invalid' : '' }}" required>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <option value="{{ $day }}" {{ old('day', $meal->day) === $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Meal Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="meal_name" class="form-control {{ $errors->has('meal_name') ? 'is-invalid' : '' }}"
                        value="{{ old('meal_name', $meal->meal_name) }}" required>
                    @error('meal_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Meal Type</label>
                    <select name="meal_type" class="form-control {{ $errors->has('meal_type') ? 'is-invalid' : '' }}">
                        <option value="">— Select type —</option>
                        @foreach($mealTypes as $type)
                            <option value="{{ $type }}" {{ old('meal_type', $meal->meal_type) === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('meal_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    {{-- placeholder to keep grid aligned --}}
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Quantity <span style="color:var(--danger)">*</span></label>
                    <input type="number" name="quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                        value="{{ old('quantity', $meal->quantity) }}" step="0.01" min="0" required>
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Unit <span style="color:var(--danger)">*</span></label>
                    <select name="unit" class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" required>
                        @foreach(['serving','piece','kg','g','liter','ml','cup','pack','box','tray'] as $unit)
                            <option value="{{ $unit }}" {{ old('unit', $meal->unit) === $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                        @endforeach
                    </select>
                    @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>
    </div>

    <div class="card" style="margin-bottom:24px;">
        <div class="card-header">
            <h3>Ingredients</h3>
            <button type="button" class="btn btn-primary btn-sm" id="add-ingredient-btn">
                <i class="fas fa-plus"></i> Add Ingredient
            </button>
        </div>
        <div class="card-body">
            <p style="font-size:13px;color:var(--muted);margin-bottom:16px;">
                <i class="fas fa-info-circle"></i> Changes here will update the Ingredients page as well.
            </p>

            <div style="display:grid;grid-template-columns:2fr 100px 130px 120px 36px;gap:10px;margin-bottom:6px;">
                <div style="font-size:12px;color:var(--muted);">Name</div>
                <div style="font-size:12px;color:var(--muted);">Quantity</div>
                <div style="font-size:12px;color:var(--muted);">Unit</div>
                <div style="font-size:12px;color:var(--muted);">Price/unit (₱)</div>
                <div></div>
            </div>

            <div id="ingredients-container">
                @forelse($meal->ingredients as $idx => $ingredient)
                <div class="ingredient-input-row" style="display:grid;grid-template-columns:2fr 100px 130px 120px 36px;gap:10px;margin-bottom:10px;align-items:start;">
                    <input type="hidden" name="ingredients[{{ $idx }}][id]" value="{{ $ingredient->id }}">
                    <input type="text" name="ingredients[{{ $idx }}][name]" class="form-control"
                        placeholder="Ingredient name" value="{{ old('ingredients.'.$idx.'.name', $ingredient->name) }}">
                    <input type="number" name="ingredients[{{ $idx }}][quantity]" class="form-control"
                        placeholder="Qty" step="0.01" min="0" value="{{ old('ingredients.'.$idx.'.quantity', $ingredient->quantity) }}">
                    <select name="ingredients[{{ $idx }}][unit]" class="form-control">
                        @foreach(['g','kg','ml','l','cup','tsp','tbsp','piece','pack'] as $u)
                            <option value="{{ $u }}" {{ old('ingredients.'.$idx.'.unit', $ingredient->unit) === $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="ingredients[{{ $idx }}][price_per_unit]" class="form-control"
                        placeholder="₱/unit" step="0.01" min="0" value="{{ old('ingredients.'.$idx.'.price_per_unit', $ingredient->price_per_unit) }}">
                    <button type="button" class="btn btn-danger btn-icon remove-ingredient" style="height:40px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @empty
                <div class="ingredient-input-row" style="display:grid;grid-template-columns:2fr 100px 130px 120px 36px;gap:10px;margin-bottom:10px;align-items:start;">
                    <input type="text" name="ingredients[0][name]" class="form-control" placeholder="Ingredient name">
                    <input type="number" name="ingredients[0][quantity]" class="form-control" placeholder="Qty" step="0.01" min="0">
                    <select name="ingredients[0][unit]" class="form-control">
                        @foreach(['g','kg','ml','l','cup','tsp','tbsp','piece','pack'] as $u)
                            <option value="{{ $u }}">{{ $u }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="ingredients[0][price_per_unit]" class="form-control" placeholder="₱/unit" step="0.01" min="0">
                    <button type="button" class="btn btn-danger btn-icon remove-ingredient" style="height:40px;"><i class="fas fa-times"></i></button>
                </div>
                @endforelse
            </div>

        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:12px;">
        <a href="{{ route('meals.index') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-gold">
            <i class="fas fa-save"></i> Update Meal
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
let ingCount = {{ $meal->ingredients->count() ?: 1 }};

const unitOptions = ['g','kg','ml','l','cup','tsp','tbsp','piece','pack']
    .map(u => `<option value="${u}">${u}</option>`).join('');

document.getElementById('add-ingredient-btn').addEventListener('click', function () {
    const container = document.getElementById('ingredients-container');
    const row = document.createElement('div');
    row.className = 'ingredient-input-row';
    row.style.cssText = 'display:grid;grid-template-columns:2fr 100px 130px 120px 36px;gap:10px;margin-bottom:10px;align-items:start;';
    row.innerHTML = `
        <input type="text"   name="ingredients[${ingCount}][name]"           class="form-control" placeholder="Ingredient name">
        <input type="number" name="ingredients[${ingCount}][quantity]"        class="form-control" placeholder="Qty" step="0.01" min="0">
        <select              name="ingredients[${ingCount}][unit]"            class="form-control">${unitOptions}</select>
        <input type="number" name="ingredients[${ingCount}][price_per_unit]"  class="form-control" placeholder="₱/unit" step="0.01" min="0">
        <button type="button" class="btn btn-danger btn-icon remove-ingredient" style="height:40px;"><i class="fas fa-times"></i></button>
    `;
    container.appendChild(row);
    ingCount++;
    row.querySelector('input').focus();
});

document.getElementById('ingredients-container').addEventListener('click', function (e) {
    if (e.target.closest('.remove-ingredient')) {
        const rows = document.querySelectorAll('.ingredient-input-row');
        if (rows.length > 1) e.target.closest('.ingredient-input-row').remove();
    }
});
</script>
@endpush