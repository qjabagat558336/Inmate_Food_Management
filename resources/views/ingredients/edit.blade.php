@extends('layouts.app')

@php $title = 'Edit Ingredient'; @endphp

@section('topbar-actions')
    <a href="{{ route('ingredients.index') }}" class="btn-secondary">← Back to ingredients</a>
@endsection

@section('content')

    <div class="form-card">
        <form method="POST" action="{{ route('ingredients.update', $ingredient) }}">
            @csrf
            @method('PUT')

            <div class="form-row-2">
                <div>
                    <label class="form-label" for="name">Ingredient Name</label>
                    <input class="form-input" type="text" id="name" name="name"
                           value="{{ old('name', $ingredient->name) }}" required>
                    @error('name')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="category">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        @foreach(['Dry goods','Protein','Dairy','Produce','Bakery','Condiments','Beverages'] as $cat)
                            <option value="{{ $cat }}"
                                {{ old('category', $ingredient->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row-3">
                <div>
                    <label class="form-label" for="quantity">Current Quantity</label>
                    <input class="form-input" type="number" id="quantity" name="quantity"
                           value="{{ old('quantity', $ingredient->quantity) }}" min="0" step="0.01" required>
                    @error('quantity')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="quantity_max">Max Capacity</label>
                    <input class="form-input" type="number" id="quantity_max" name="quantity_max"
                           value="{{ old('quantity_max', $ingredient->quantity_max) }}" min="1" step="0.01" required>
                    @error('quantity_max')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="unit">Unit</label>
                    <select class="form-select" id="unit" name="unit" required>
                        @foreach(['kg','g','L','ml','pcs','loaves','dozen','bags'] as $u)
                            <option value="{{ $u }}"
                                {{ old('unit', $ingredient->unit) === $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                    @error('unit')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- PRICING SECTION --}}
            <div style="margin-top:8px;">
                <label class="form-label" style="margin-bottom:10px;display:block;">Pricing</label>
                <div class="form-row-3">
                    <div>
                        <label class="form-label" for="price_per_unit">Price per Unit (₱)</label>
                        <input class="form-input" type="number" id="price_per_unit" name="price_per_unit"
                               value="{{ old('price_per_unit', $ingredient->price_per_unit ?? 0) }}"
                               min="0" step="0.01" placeholder="0.00">
                        @error('price_per_unit')<div class="error-text">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label" for="price_quantity">Quantity</label>
                        <input class="form-input" type="number" id="price_quantity" name="price_quantity"
                               value="{{ old('price_quantity', $ingredient->quantity ?? 0) }}"
                               min="0" step="0.01" placeholder="0">
                        <div style="font-size:11px;color:#888;margin-top:3px;">Auto-filled from quantity above</div>
                    </div>
                    <div>
                        <label class="form-label">Total Price (₱)</label>
                        <input class="form-input" type="text" id="price_total_display" readonly
                               value="₱{{ number_format(($ingredient->price_per_unit ?? 0) * ($ingredient->quantity ?? 0), 2) }}"
                               style="background:#f8f7f4;cursor:default;font-weight:600;color:#1e8a4a;">
                        <input type="hidden" name="price" id="price_hidden"
                               value="{{ ($ingredient->price_per_unit ?? 0) * ($ingredient->quantity ?? 0) }}">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <label class="form-label" for="notes">Notes (optional)</label>
                <textarea class="form-textarea" id="notes" name="notes">{{ old('notes', $ingredient->notes) }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('ingredients.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update ingredient</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
const pricePerUnitInput  = document.getElementById('price_per_unit');
const priceQtyInput      = document.getElementById('price_quantity');
const quantityInput      = document.getElementById('quantity');
const totalDisplay       = document.getElementById('price_total_display');
const priceHidden        = document.getElementById('price_hidden');

function recalcTotal() {
    const ppu   = parseFloat(pricePerUnitInput.value)  || 0;
    const qty   = parseFloat(priceQtyInput.value)      || 0;
    const total = ppu * qty;
    totalDisplay.value  = '₱' + total.toFixed(2);
    priceHidden.value   = total.toFixed(2);
}

// Keep price_quantity in sync with the main quantity field
quantityInput.addEventListener('input', function () {
    priceQtyInput.value = this.value;
    recalcTotal();
});

pricePerUnitInput.addEventListener('input', recalcTotal);
priceQtyInput.addEventListener('input', recalcTotal);
</script>
@endpush