@extends('layouts.app')
@section('title', 'Ingredients')

@section('content')

{{-- Gradient Orbs --}}
<div class="dash-orb dash-orb-1"></div>
<div class="dash-orb dash-orb-2"></div>
<div class="dash-orb dash-orb-3"></div>

{{-- Page Header --}}
<div class="page-header" style="margin-bottom:32px;position:relative;z-index:1;">
    <div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;">
            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--gold),var(--gold-lt));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(200,149,42,.35);">
                <i class="fas fa-carrot" style="color:#fff;font-size:16px;"></i>
            </div>
            <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:1px;color:var(--navy);line-height:1;">Ingredients</h2>
        </div>
        <p style="color:var(--muted);font-size:13px;margin-top:2px;font-family:'DM Mono',monospace;letter-spacing:.3px;">
            All ingredients grouped by meal — <strong style="color:var(--navy);">{{ $meals->count() }}</strong> meals listed
        </p>
    </div>
    <a href="{{ route('meals.create') }}" class="btn btn-gold" style="padding:11px 22px;font-size:14px;font-weight:600;box-shadow:0 4px 14px rgba(200,149,42,.35);">
        <i class="fas fa-plus"></i> Add Meal
    </a>
</div>

@if($meals->isEmpty())
<div style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);position:relative;z-index:1;">
    <div style="text-align:center;padding:72px 40px;">
        <div style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,rgba(200,149,42,.1),rgba(200,149,42,.05));border:1px solid rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="fas fa-carrot" style="font-size:30px;color:var(--cream-dk);"></i>
        </div>
        <h3 style="color:var(--muted);font-weight:400;margin-bottom:8px;font-size:20px;">No ingredients yet</h3>
        <p style="color:var(--muted);font-size:14px;margin-bottom:24px;">Add a meal with ingredients to see them listed here.</p>
        <a href="{{ route('meals.create') }}" class="btn btn-gold" style="box-shadow:0 4px 14px rgba(200,149,42,.3);">Add First Meal</a>
    </div>
</div>
@else

{{-- Search Bar --}}
<div style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 12px rgba(0,0,0,.06);margin-bottom:24px;overflow:hidden;position:relative;z-index:1;">
    <div style="padding:16px 24px;display:flex;align-items:center;gap:10px;border-bottom:2px solid var(--gold);background:linear-gradient(120deg,#0B1D33 0%,#142947 100%);">
        <i class="fas fa-search" style="color:var(--gold);font-size:13px;"></i>
        <span style="font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:.5px;color:#fff;">Search Ingredients</span>
    </div>
    <div style="padding:16px 24px;">
        <form method="GET" action="{{ route('ingredients.index') }}" style="display:flex;gap:12px;align-items:center;">
            <div style="position:relative;flex:1;max-width:360px;">
                <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px;pointer-events:none;"></i>
                <input type="text" name="search" class="form-control" style="padding-left:36px;"
                    placeholder="Search ingredient or meal name..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="gap:6px;">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('ingredients.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>
</div>

@php
    $maxCost = $meals->map(fn($m) => $m->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit))->max() ?: 1;
@endphp

{{-- Card Grid --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(400px,1fr));gap:20px;position:relative;z-index:1;">
    @foreach($meals as $meal)
    @php
        $totalCost   = $meal->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit);
        $ingCount    = $meal->ingredients->count();
        $progressPct = round(($totalCost / $maxCost) * 100);
        $dayColors   = [
            'Monday'    => ['bg'=>'#e8f4fd','color'=>'#1a6fa8','bar'=>'#3490dc'],
            'Tuesday'   => ['bg'=>'#edf7ee','color'=>'#1e7e34','bar'=>'#28a745'],
            'Wednesday' => ['bg'=>'#fdf3e3','color'=>'#a05c00','bar'=>'#e67e22'],
            'Thursday'  => ['bg'=>'#f3eafd','color'=>'#6a2fa0','bar'=>'#9b59b6'],
            'Friday'    => ['bg'=>'#fdeaea','color'=>'#a02020','bar'=>'#e74c3c'],
            'Saturday'  => ['bg'=>'#e8f4fd','color'=>'#0d5c8a','bar'=>'#2980b9'],
            'Sunday'    => ['bg'=>'#fff3e0','color'=>'#b85c00','bar'=>'#f39c12'],
        ];
        $dc = $dayColors[$meal->day] ?? ['bg'=>'#f0f0f0','color'=>'#555','bar'=>'#999'];
    @endphp

    <div style="background:#fff;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 4px 20px rgba(0,0,0,.07);border:1px solid var(--cream-dk);transition:transform .2s,box-shadow .2s;" class="ing-card">

        {{-- Card Top Accent --}}
        <div style="height:4px;background:linear-gradient(90deg,{{ $dc['bar'] }},{{ $dc['color'] }});"></div>

        {{-- Card Header --}}
        <div style="padding:16px 18px 14px;border-bottom:1px solid var(--cream-dk);background:linear-gradient(160deg,#fff 0%,{{ $dc['bg'] }}44 100%);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:4px 10px;border-radius:20px;background:{{ $dc['bg'] }};color:{{ $dc['color'] }};border:1px solid {{ $dc['color'] }}22;">
                    {{ $meal->day }}
                </span>
                <span style="font-size:10px;font-weight:600;background:var(--cream);border:1px solid var(--cream-dk);color:var(--muted);padding:3px 9px;border-radius:20px;">
                    {{ $ingCount }} {{ Str::plural('ingredient', $ingCount) }}
                </span>
            </div>

            <div style="font-size:15px;font-weight:600;color:var(--navy);margin-bottom:4px;line-height:1.3;">
                {{ $meal->meal_name }}
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                @if($meal->meal_type)
                <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                    <i class="fas fa-tag" style="font-size:9px;color:var(--gold);"></i> {{ $meal->meal_type }}
                </span>
                @endif
                <span style="font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;">
                    <i class="fas fa-scale-balanced" style="font-size:9px;color:var(--gold);"></i> {{ $meal->quantity }} {{ $meal->unit }}
                </span>
            </div>
        </div>

        {{-- Ingredients List --}}
        <div style="padding:12px 18px;flex:1;">
            @if($meal->ingredients->isEmpty())
                <div style="border:1.5px dashed var(--cream-dk);border-radius:10px;padding:20px;text-align:center;margin:4px 0;background:var(--cream);">
                    <i class="fas fa-carrot" style="font-size:20px;color:var(--cream-dk);display:block;margin-bottom:8px;"></i>
                    <p style="font-size:12px;color:var(--muted);margin:0 0 8px;">No ingredients listed.</p>
                    <a href="{{ route('meals.edit', $meal->id) }}" style="font-size:11px;color:var(--gold);text-decoration:none;font-weight:600;">
                        <i class="fas fa-plus" style="font-size:10px;"></i> Add ingredients
                    </a>
                </div>
            @else
                {{-- Column headers --}}
                <div style="display:grid;grid-template-columns:minmax(110px,1fr) 52px 48px 72px 82px;gap:6px;padding:7px 10px;background:linear-gradient(135deg,var(--navy),#1E3A5F);border-radius:8px;margin-bottom:6px;">
                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gold);">Name</span>
                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gold);text-align:right;">Qty</span>
                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gold);text-align:center;">Unit</span>
                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gold);text-align:right;">₱/unit</span>
                    <span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gold);text-align:right;">Subtotal</span>
                </div>

                {{-- Ingredient rows --}}
                @foreach($meal->ingredients as $ingredient)
                @php
                    $qty      = (float) $ingredient->quantity;
                    $ppu      = (float) $ingredient->price_per_unit;
                    $subtotal = $qty * $ppu;
                @endphp
                <div class="ing-row" style="display:grid;grid-template-columns:minmax(110px,1fr) 52px 48px 72px 82px;gap:6px;padding:7px 6px;border-bottom:1px solid var(--cream-dk);align-items:center;border-radius:6px;transition:background .15s;">
                    <span style="font-size:12px;color:var(--navy);display:flex;align-items:center;gap:6px;min-width:0;">
                        <span style="width:6px;height:6px;border-radius:50%;background:{{ $dc['bar'] }};display:inline-block;flex-shrink:0;"></span>
                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ingredient->name }}</span>
                    </span>
                    <span style="font-size:11px;color:var(--muted);font-family:'DM Mono',monospace;text-align:right;white-space:nowrap;">{{ number_format($qty, 2) }}</span>
                    <span style="text-align:center;">
                        <span style="font-size:9px;color:var(--muted);background:var(--cream);border:1px solid var(--cream-dk);border-radius:4px;padding:2px 5px;display:inline-block;white-space:nowrap;">{{ $ingredient->unit ?? '—' }}</span>
                    </span>
                    <span style="font-size:11px;color:var(--muted);font-family:'DM Mono',monospace;text-align:right;white-space:nowrap;">₱{{ number_format($ppu, 2) }}</span>
                    <span style="font-size:11px;color:var(--navy);font-family:'DM Mono',monospace;text-align:right;font-weight:700;white-space:nowrap;">₱{{ number_format($subtotal, 2) }}</span>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Total Cost --}}
        <div style="padding:10px 18px 12px;background:linear-gradient(135deg,var(--cream),#f0ead6);border-top:1px solid var(--cream-dk);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <span style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Total cost</span>
                <span style="font-size:13px;font-weight:700;color:var(--navy);font-family:'DM Mono',monospace;">₱{{ number_format($totalCost, 2) }}</span>
            </div>
            <div style="height:5px;background:rgba(0,0,0,.08);border-radius:10px;overflow:hidden;">
                <div style="height:100%;width:{{ $progressPct }}%;background:linear-gradient(90deg,{{ $dc['bar'] }},{{ $dc['color'] }});border-radius:10px;transition:width .6s ease;"></div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="padding:10px 18px;display:flex;gap:8px;border-top:1px solid var(--cream-dk);background:#fff;">
            <a href="{{ route('meals.edit', $meal->id) }}"
                style="flex:1;text-align:center;padding:7px 0;border-radius:8px;border:1px solid var(--cream-dk);background:var(--cream);font-size:12px;font-weight:600;color:var(--navy);text-decoration:none;display:flex;align-items:center;justify-content:center;gap:5px;transition:all .2s;"
                onmouseover="this.style.background='var(--navy)';this.style.color='#fff';this.style.borderColor='var(--navy)'"
                onmouseout="this.style.background='var(--cream)';this.style.color='var(--navy)';this.style.borderColor='var(--cream-dk)'">
                <i class="fas fa-pencil" style="font-size:11px;"></i> Edit
            </a>
            <form method="POST" action="{{ route('meals.destroy', $meal->id) }}" style="flex:1;">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDelete(this.closest('form'))"
                    style="width:100%;padding:7px 0;border-radius:8px;border:1px solid rgba(192,57,43,.25);background:rgba(192,57,43,.05);font-size:12px;font-weight:600;color:#c0392b;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;transition:all .2s;"
                    onmouseover="this.style.background='#c0392b';this.style.color='#fff';this.style.borderColor='#c0392b'"
                    onmouseout="this.style.background='rgba(192,57,43,.05)';this.style.color='#c0392b';this.style.borderColor='rgba(192,57,43,.25)'">
                    <i class="fas fa-trash" style="font-size:11px;"></i> Delete
                </button>
            </form>
        </div>

    </div>
    @endforeach
</div>

@endif

{{-- Edit Ingredient Modal --}}
<div class="modal-overlay" id="edit-ing-modal">
    <div class="modal-box" style="border-radius:16px;overflow:hidden;">
        <div class="modal-header" style="background:linear-gradient(120deg,#0B1D33,#1E3A5F);border-bottom:3px solid var(--gold);">
            <h4 style="font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:.5px;">Edit Ingredient</h4>
            <button class="modal-close" onclick="closeEditIngModal()"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" id="edit-ing-form">
            @csrf @method('PUT')
            <div class="modal-body" style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);">
                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-tag" style="color:var(--gold);font-size:11px;"></i> Ingredient Name
                    </label>
                    <input type="text" name="name" id="edit-ing-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-hashtag" style="color:var(--gold);font-size:11px;"></i> Quantity
                    </label>
                    <input type="number" name="quantity" id="edit-ing-qty" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-scale-balanced" style="color:var(--gold);font-size:11px;"></i> Unit
                    </label>
                    <input type="text" name="unit" id="edit-ing-unit" class="form-control">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-peso-sign" style="color:var(--gold);font-size:11px;"></i> Price per Unit (₱)
                    </label>
                    <input type="number" name="price_per_unit" id="edit-ing-ppu" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
            <div class="modal-footer" style="background:var(--cream);border-top:1px solid var(--cream-dk);">
                <button type="button" class="btn btn-outline" onclick="closeEditIngModal()">Cancel</button>
                <button type="submit" class="btn btn-gold" style="box-shadow:0 3px 10px rgba(200,149,42,.3);">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.content {
    background:
        radial-gradient(ellipse 70% 50% at 5% 0%, rgba(200,149,42,.1) 0%, transparent 55%),
        radial-gradient(ellipse 60% 50% at 95% 100%, rgba(139,164,191,.1) 0%, transparent 55%),
        var(--cream);
    background-attachment: fixed;
}
.dash-orb { position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;animation:orbFloat 14s ease-in-out infinite alternate; }
.dash-orb-1 { width:460px;height:460px;background:radial-gradient(circle,rgba(200,149,42,.16) 0%,transparent 70%);top:-120px;right:40px; }
.dash-orb-2 { width:340px;height:340px;background:radial-gradient(circle,rgba(139,164,191,.14) 0%,transparent 70%);bottom:60px;left:40px;animation-delay:-7s; }
.dash-orb-3 { width:260px;height:260px;background:radial-gradient(circle,rgba(11,29,51,.08) 0%,transparent 70%);top:40%;right:10px;animation-delay:-11s; }
@keyframes orbFloat { 0%{transform:translate(0,0) scale(1)} 100%{transform:translate(22px,18px) scale(1.08)} }
.content > * { position:relative;z-index:1; }
.ing-card:hover { transform:translateY(-3px);box-shadow:0 10px 30px rgba(0,0,0,.1) !important; }
.ing-row:hover { background:var(--cream); }
</style>
@endpush

@push('scripts')
<script>
function openEditIngredient(id, name, qty, unit, ppu) {
    document.getElementById('edit-ing-form').action = `/ingredients/${id}`;
    document.getElementById('edit-ing-name').value  = name;
    document.getElementById('edit-ing-qty').value   = qty;
    document.getElementById('edit-ing-unit').value  = unit;
    document.getElementById('edit-ing-ppu').value   = ppu;
    document.getElementById('edit-ing-modal').classList.add('open');
}
function closeEditIngModal() {
    document.getElementById('edit-ing-modal').classList.remove('open');
}
document.getElementById('edit-ing-modal').addEventListener('click', function(e) {
    if (e.target === this) closeEditIngModal();
});
</script>
@endpush