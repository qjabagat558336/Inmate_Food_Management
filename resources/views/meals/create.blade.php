@extends('layouts.app')
@section('title', 'Add Meal')

@section('content')

{{-- Gradient Orbs --}}
<div class="dash-orb dash-orb-1"></div>
<div class="dash-orb dash-orb-2"></div>

{{-- Page Header --}}
<div class="page-header" style="margin-bottom:32px;">
    <div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;">
            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--gold),var(--gold-lt));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(200,149,42,.35);">
                <i class="fas fa-utensils" style="color:#fff;font-size:16px;"></i>
            </div>
            <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:1px;color:var(--navy);line-height:1;">Add New Meal</h2>
        </div>
        <p style="color:var(--muted);font-size:13px;margin-top:2px;font-family:'DM Mono',monospace;letter-spacing:.3px;">Fill in the meal details and ingredients below.</p>
    </div>
    <a href="{{ route('meals.index') }}" class="btn btn-outline" style="gap:8px;">
        <i class="fas fa-arrow-left"></i> Back to Records
    </a>
</div>

<form method="POST" action="{{ route('meals.store') }}" id="meal-form">
    @csrf

    {{-- MEAL INFORMATION --}}
    <div style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;margin-bottom:24px;position:relative;z-index:1;">

        {{-- Card Header --}}
        <div style="padding:18px 26px;display:flex;align-items:center;gap:14px;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);border-bottom:3px solid var(--gold);">
            <div style="width:34px;height:34px;border-radius:8px;background:rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-bowl-food" style="color:var(--gold);font-size:14px;"></i>
            </div>
            <div>
                <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:#fff;line-height:1;">Meal Information</h3>
                <p style="font-size:11px;color:var(--steel);margin-top:1px;font-family:'DM Mono',monospace;">Basic details about the meal</p>
            </div>
        </div>

        <div style="padding:28px 26px;">

            {{-- Row 1: Day + Meal Name --}}
            <div class="form-grid-2" style="margin-bottom:0;">
                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-calendar-day" style="color:var(--gold);font-size:11px;"></i>
                        Day <span style="color:var(--danger)">*</span>
                    </label>
                    <select name="day" class="form-control {{ $errors->has('day') ? 'is-invalid' : '' }}" required>
                        <option value="">— Select Day —</option>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <option value="{{ $day }}" {{ old('day') === $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-utensils" style="color:var(--gold);font-size:11px;"></i>
                        Meal Name <span style="color:var(--danger)">*</span>
                    </label>
                    <input type="text" name="meal_name" class="form-control {{ $errors->has('meal_name') ? 'is-invalid' : '' }}"
                        value="{{ old('meal_name') }}" placeholder="e.g. Chicken Adobo" required>
                    @error('meal_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:linear-gradient(90deg,transparent,var(--cream-dk),transparent);margin:4px 0 20px;"></div>

            {{-- Row 2: Meal Type --}}
            <div style="max-width:50%;padding-right:10px;">
                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-tag" style="color:var(--gold);font-size:11px;"></i>
                        Meal Type
                    </label>
                    <select name="meal_type" class="form-control {{ $errors->has('meal_type') ? 'is-invalid' : '' }}">
                        <option value="">— Select Meal Type —</option>
                        @foreach($mealTypes as $type)
                            <option value="{{ $type }}" {{ old('meal_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('meal_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:linear-gradient(90deg,transparent,var(--cream-dk),transparent);margin:4px 0 20px;"></div>

            {{-- Row 3: Quantity + Unit --}}
            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-hashtag" style="color:var(--gold);font-size:11px;"></i>
                        Quantity <span style="color:var(--danger)">*</span>
                    </label>
                    <input type="number" name="quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                        value="{{ old('quantity') }}" placeholder="0" step="0.01" min="0" required>
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-scale-balanced" style="color:var(--gold);font-size:11px;"></i>
                        Unit <span style="color:var(--danger)">*</span>
                    </label>
                    <select name="unit" class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" required>
                        <option value="">— Select Unit —</option>
                        @foreach(['serving','piece'] as $unit)
                            <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                        @endforeach
                    </select>
                    @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>
    </div>

    {{-- INGREDIENTS --}}
    <div style="background:linear-gradient(160deg,#fff 0%,#f5f8fc 100%);border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;margin-bottom:28px;position:relative;z-index:1;">

        {{-- Card Header --}}
        <div style="padding:18px 26px;display:flex;align-items:center;justify-content:space-between;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);border-bottom:3px solid var(--gold);">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:34px;height:34px;border-radius:8px;background:rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-carrot" style="color:var(--gold);font-size:14px;"></i>
                </div>
                <div>
                    <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:#fff;line-height:1;">Ingredients</h3>
                    <p style="font-size:11px;color:var(--steel);margin-top:1px;font-family:'DM Mono',monospace;">Add all ingredients with cost</p>
                </div>
            </div>
            <button type="button" id="add-ingredient-btn"
                style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,var(--gold),var(--gold-lt));color:#fff;border:none;font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;box-shadow:0 3px 10px rgba(200,149,42,.4);transition:all .2s;"
                onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 5px 16px rgba(200,149,42,.5)'"
                onmouseout="this.style.transform='';this.style.boxShadow='0 3px 10px rgba(200,149,42,.4)'">
                <i class="fas fa-plus"></i> Add Ingredient
            </button>
        </div>

        <div style="padding:22px 26px;">

            {{-- Info bar --}}
            <div style="display:flex;align-items:center;gap:10px;padding:11px 16px;background:linear-gradient(135deg,rgba(52,144,220,.07),rgba(52,144,220,.03));border:1px solid rgba(52,144,220,.2);border-radius:9px;margin-bottom:18px;">
                <i class="fas fa-info-circle" style="color:#3490dc;font-size:14px;flex-shrink:0;"></i>
                <span style="font-size:13px;color:#2177b8;font-weight:500;">Enter each ingredient with its quantity, unit, and price per unit. The total will be calculated automatically.</span>
            </div>

            {{-- Column Headers --}}
            <div style="display:grid;grid-template-columns:1fr 110px 130px 140px 120px 40px;gap:10px;margin-bottom:8px;padding:10px 14px;background:linear-gradient(135deg,var(--navy),#1E3A5F);border-radius:9px;">
                <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">Ingredient Name</div>
                <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">Quantity</div>
                <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">Unit</div>
                <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">Price / Unit (₱)</div>
                <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">Total (₱)</div>
                <div></div>
            </div>

            <div id="ing-rows-container"></div>

            {{-- Grand Total --}}
            <div style="display:flex;justify-content:flex-end;align-items:center;gap:16px;margin-top:18px;padding:16px 20px;border-radius:12px;background:linear-gradient(135deg,rgba(26,122,74,.07),rgba(26,122,74,.03));border:1px solid rgba(26,122,74,.15);">
                <span style="font-size:14px;font-weight:600;color:var(--navy);font-family:'DM Mono',monospace;">Ingredients Total:</span>
                <span id="ing-grand-total" style="font-family:'DM Mono',monospace;font-size:24px;font-weight:700;color:#1A7A4A;">₱0.00</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div style="display:flex;justify-content:flex-end;gap:12px;position:relative;z-index:1;">
        <a href="{{ route('meals.index') }}" class="btn btn-outline">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="btn btn-gold" style="padding:11px 28px;font-size:14px;font-weight:600;box-shadow:0 4px 14px rgba(200,149,42,.35);">
            <i class="fas fa-save"></i> Save Meal
        </button>
    </div>

</form>
@endsection

@push('styles')
<style>
/* Orbs */
.dash-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    z-index: 0;
    animation: orbFloat 14s ease-in-out infinite alternate;
}
.dash-orb-1 {
    width: 460px; height: 460px;
    background: radial-gradient(circle, rgba(200,149,42,.15) 0%, transparent 70%);
    top: -120px; right: 40px;
}
.dash-orb-2 {
    width: 340px; height: 340px;
    background: radial-gradient(circle, rgba(52,144,220,.12) 0%, transparent 70%);
    bottom: 60px; left: 40px;
    animation-delay: -7s;
}
@keyframes orbFloat {
    0%   { transform: translate(0,0) scale(1); }
    100% { transform: translate(20px,18px) scale(1.08); }
}

/* Page background */
.content {
    background:
        radial-gradient(ellipse 70% 50% at 10% 0%, rgba(200,149,42,.1) 0%, transparent 55%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(52,144,220,.08) 0%, transparent 55%),
        var(--cream);
    background-attachment: fixed;
}

/* Ingredient row styling */
.ingredient-input-row {
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid var(--cream-dk);
    margin-bottom: 8px;
    background: #fff;
    transition: box-shadow .2s, border-color .2s;
}
.ingredient-input-row:hover {
    border-color: rgba(200,149,42,.3);
    box-shadow: 0 2px 10px rgba(200,149,42,.08);
}

/* form control focus gold ring */
.form-control:focus {
    border-color: var(--gold) !important;
    box-shadow: 0 0 0 3px rgba(200,149,42,.12) !important;
}

/* Labels */
.form-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* Remove button */
.ing-remove-btn {
    width: 36px; height: 36px;
    border-radius: 8px;
    border: none;
    background: rgba(192,57,43,.08);
    color: var(--danger);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    transition: all .2s;
}
.ing-remove-btn:hover {
    background: var(--danger);
    color: #fff;
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
let ingCount = 0;
const unitOptions = ['kg','g','liter','ml','cup','piece','pack','tray','tbsp','tsp'];

function buildUnitOptions(selected = '') {
    return '<option value="">— Unit —</option>' +
        unitOptions.map(u => `<option value="${u}" ${selected === u ? 'selected' : ''}>${u}</option>`).join('');
}

function addIngRow(nameVal = '', qtyVal = '', unitVal = '', priceVal = '') {
    const container = document.getElementById('ing-rows-container');
    const idx = ingCount;
    const row = document.createElement('div');
    row.className = 'ingredient-input-row';
    row.style.cssText = 'display:grid;grid-template-columns:1fr 110px 130px 140px 120px 40px;gap:10px;align-items:center;';
    row.innerHTML = `
        <input type="text" name="ingredients[${idx}][name]"
            class="form-control ing-name" placeholder="e.g. Chicken" value="${nameVal}" style="font-size:13px;">
        <input type="number" name="ingredients[${idx}][quantity]"
            class="form-control ing-qty" placeholder="0" step="0.01" min="0" value="${qtyVal}" style="font-size:13px;">
        <select name="ingredients[${idx}][unit]" class="form-control ing-unit" style="font-size:13px;">
            ${buildUnitOptions(unitVal)}
        </select>
        <input type="number" name="ingredients[${idx}][price_per_unit]"
            class="form-control ing-price" placeholder="0.00" step="0.01" min="0" value="${priceVal}" style="font-size:13px;">
        <input type="text" class="form-control ing-row-total" value="₱0.00" readonly
            style="background:linear-gradient(135deg,rgba(26,122,74,.06),rgba(26,122,74,.03));font-family:'DM Mono',monospace;font-size:13px;font-weight:700;color:#1A7A4A;text-align:right;cursor:default;border-color:rgba(26,122,74,.2);">
        <button type="button" onclick="removeIngRow(this)" class="ing-remove-btn" title="Remove">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(row);
    ingCount++;

    const qtyInput   = row.querySelector('.ing-qty');
    const priceInput = row.querySelector('.ing-price');
    const rowTotal   = row.querySelector('.ing-row-total');

    function updateRow() {
        const qty   = parseFloat(qtyInput.value)  || 0;
        const price = parseFloat(priceInput.value) || 0;
        rowTotal.value = '₱' + (qty * price).toFixed(2);
        recalcGrandTotal();
    }

    qtyInput.addEventListener('input', updateRow);
    priceInput.addEventListener('input', updateRow);
    if (qtyVal || priceVal) updateRow();
}

function removeIngRow(btn) {
    const rows = document.querySelectorAll('.ingredient-input-row');
    if (rows.length > 1) {
        btn.closest('.ingredient-input-row').remove();
        recalcGrandTotal();
    }
}

function recalcGrandTotal() {
    let total = 0;
    document.querySelectorAll('.ing-row-total').forEach(input => {
        total += parseFloat(input.value.replace('₱', '')) || 0;
    });
    document.getElementById('ing-grand-total').textContent = '₱' + total.toFixed(2);
}

document.getElementById('add-ingredient-btn').addEventListener('click', () => addIngRow());

@if(old('ingredients'))
    @foreach(old('ingredients') as $ing)
        addIngRow(
            '{{ addslashes($ing["name"] ?? "") }}',
            '{{ $ing["quantity"] ?? "" }}',
            '{{ $ing["unit"] ?? "" }}',
            '{{ $ing["price_per_unit"] ?? "" }}'
        );
    @endforeach
@else
    addIngRow();
@endif
</script>
@endpush