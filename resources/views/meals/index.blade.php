@extends('layouts.app')
@section('title', 'Meal Records')

@section('content')

{{-- Gradient Orbs --}}
<div class="dash-orb dash-orb-1"></div>
<div class="dash-orb dash-orb-2"></div>

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:32px;position:relative;z-index:1;">
    <div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;">
            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--gold),var(--gold-lt));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(200,149,42,.35);">
                <i class="fas fa-clipboard-list" style="color:#fff;font-size:16px;"></i>
            </div>
            <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:1px;color:var(--navy);line-height:1;">Meal Records</h2>
        </div>
        <p style="color:var(--muted);font-size:13px;margin-top:2px;font-family:'DM Mono',monospace;letter-spacing:.3px;">
            All recorded meals — <strong style="color:var(--navy);">{{ $meals->count() }} total</strong>
        </p>
    </div>
    <a href="{{ route('meals.create') }}" class="btn btn-gold" style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;font-size:14px;">
        <i class="fas fa-plus"></i> Add Meal
    </a>
</div>

@if(session('success'))
<div style="display:flex;align-items:center;gap:10px;padding:13px 18px;background:linear-gradient(135deg,rgba(26,122,74,.08),rgba(26,122,74,.03));border:1px solid rgba(26,122,74,.25);border-radius:10px;margin-bottom:20px;position:relative;z-index:1;">
    <i class="fas fa-check-circle" style="color:#1A7A4A;font-size:15px;flex-shrink:0;"></i>
    <span style="font-size:13.5px;color:#1A7A4A;font-weight:500;">{{ session('success') }}</span>
</div>
@endif

{{-- Filter Bar --}}
<div style="background:#fff;border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 12px rgba(0,0,0,.05);padding:18px 22px;margin-bottom:20px;position:relative;z-index:1;">
    <form method="GET" action="{{ route('meals.index') }}" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search meal name..."
            style="flex:1;min-width:180px;padding:9px 14px;border:1px solid var(--cream-dk);border-radius:8px;font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--navy);outline:none;background:#fafafa;">

        <select name="day" style="padding:9px 14px;border:1px solid var(--cream-dk);border-radius:8px;font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--navy);outline:none;background:#fafafa;min-width:130px;">
            <option value="">All Days</option>
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $d)
                <option value="{{ $d }}" {{ request('day') === $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach
        </select>

        <select name="meal_type" style="padding:9px 14px;border:1px solid var(--cream-dk);border-radius:8px;font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--navy);outline:none;background:#fafafa;min-width:130px;">
            <option value="">All Types</option>
            @foreach($mealTypes ?? ['Breakfast','Lunch','Dinner','Special diet'] as $t)
                <option value="{{ $t }}" {{ request('meal_type') === $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-gold" style="padding:9px 20px;font-size:13.5px;display:inline-flex;align-items:center;gap:7px;">
            <i class="fas fa-search"></i> Filter
        </button>

        @if(request()->anyFilled(['search','day','meal_type']))
        <a href="{{ route('meals.index') }}" style="font-size:13px;color:var(--muted);text-decoration:none;padding:9px 14px;border:1px solid var(--cream-dk);border-radius:8px;background:#fafafa;transition:all .2s;"
           onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='#fafafa'">
            <i class="fas fa-times"></i> Clear
        </a>
        @endif
    </form>
</div>

{{-- Table Card --}}
<div style="background:#fff;border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;position:relative;z-index:1;">

    {{-- Table Header --}}
    <div style="display:grid;grid-template-columns:2fr 1.2fr 1.2fr 1fr 1fr 1.2fr 1.3fr 1fr;gap:10px;padding:13px 22px;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);border-bottom:3px solid var(--gold);">
        @foreach(['Meal Name','Meal Type','Day','Quantity','Unit','Ingredients','Date Added','Actions'] as $col)
        <div style="font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:1px;">{{ $col }}</div>
        @endforeach
    </div>

    {{-- Rows --}}
    @forelse($meals as $meal)
    @php
        $typeColors = [
            'Breakfast'    => ['bg'=>'rgba(251,191,36,.12)','color'=>'#92400e','border'=>'rgba(251,191,36,.35)'],
            'Lunch'        => ['bg'=>'rgba(52,144,220,.1)', 'color'=>'#1e4d7b','border'=>'rgba(52,144,220,.3)'],
            'Dinner'       => ['bg'=>'rgba(139,92,246,.1)', 'color'=>'#5b21b6','border'=>'rgba(139,92,246,.3)'],
            'Special diet' => ['bg'=>'rgba(26,122,74,.1)',  'color'=>'#166534','border'=>'rgba(26,122,74,.3)'],
        ];
        $tc = $typeColors[$meal->meal_type] ?? ['bg'=>'#f1f5f9','color'=>'#475569','border'=>'#e2e8f0'];

        $dayColors = ['Monday'=>'#3b82f6','Tuesday'=>'#8b5cf6','Wednesday'=>'#f59e0b',
                      'Thursday'=>'#10b981','Friday'=>'#ef4444','Saturday'=>'#ec4899','Sunday'=>'#6366f1'];
        $dc = $dayColors[$meal->day] ?? '#64748b';

        $ingCount = $meal->ingredients_count ?? (method_exists($meal,'ingredients') ? $meal->ingredients()->count() : 0);
    @endphp
    <div style="display:grid;grid-template-columns:2fr 1.2fr 1.2fr 1fr 1fr 1.2fr 1.3fr 1fr;gap:10px;padding:15px 22px;border-bottom:1px solid #f8fafc;align-items:center;transition:background .15s;"
         onmouseover="this.style.background='#fffcf5'" onmouseout="this.style.background=''">

        {{-- Meal Name --}}
        <div>
            <div style="font-weight:700;color:var(--navy);font-size:14px;font-family:'DM Sans',sans-serif;">{{ $meal->meal_name }}</div>
        </div>

        {{-- Meal Type --}}
        <div>
            <span style="display:inline-flex;align-items:center;padding:4px 10px;border-radius:6px;font-size:11.5px;font-weight:600;background:{{ $tc['bg'] }};color:{{ $tc['color'] }};border:1px solid {{ $tc['border'] }};">
                {{ $meal->meal_type ?? '—' }}
            </span>
        </div>

        {{-- Day --}}
        <div>
            <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;font-size:11.5px;font-weight:600;background:rgba(0,0,0,.04);color:{{ $dc }};border:1px solid {{ $dc }}22;">
                {{ $meal->day ?? '—' }}
            </span>
        </div>

        {{-- Quantity --}}
        <div style="font-family:'DM Mono',monospace;font-size:13.5px;font-weight:600;color:var(--navy);">
            {{ number_format($meal->quantity, 2) }}
        </div>

        {{-- Unit --}}
        <div>
            <span style="background:#f1f5f9;border:1px solid #e2e8f0;color:#475569;font-size:12px;font-weight:600;padding:3px 10px;border-radius:6px;">
                {{ $meal->unit ?? '—' }}
            </span>
        </div>

        {{-- Ingredients --}}
        <div>
            @if($ingCount > 0)
            <span style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:7px;font-size:12px;font-weight:600;background:rgba(11,29,51,.06);color:var(--navy);border:1px solid rgba(11,29,51,.12);cursor:default;">
                <i class="fas fa-list-ul" style="font-size:10px;"></i> {{ $ingCount }} item(s)
            </span>
            @else
            <span style="font-size:12px;color:var(--muted);">—</span>
            @endif
        </div>

        {{-- Date --}}
        <div style="font-size:12.5px;color:var(--muted);font-family:'DM Mono',monospace;">
            {{ $meal->created_at->format('M d, Y') }}
        </div>

        {{-- Actions --}}
        <div style="display:flex;align-items:center;gap:7px;">
            <a href="{{ route('meals.edit', $meal) }}"
               style="width:32px;height:32px;border-radius:7px;background:rgba(52,144,220,.1);border:1px solid rgba(52,144,220,.25);color:#3490dc;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .2s;font-size:13px;"
               onmouseover="this.style.background='#3490dc';this.style.color='#fff'"
               onmouseout="this.style.background='rgba(52,144,220,.1)';this.style.color='#3490dc'"
               title="Edit">
                <i class="fas fa-pen"></i>
            </a>
            <form method="POST" action="{{ route('meals.destroy', $meal) }}" onsubmit="return confirm('Delete {{ addslashes($meal->meal_name) }}?')" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit"
                    style="width:32px;height:32px;border-radius:7px;background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.2);color:var(--danger);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;font-size:13px;"
                    onmouseover="this.style.background='var(--danger)';this.style.color='#fff'"
                    onmouseout="this.style.background='rgba(192,57,43,.08)';this.style.color='var(--danger)'"
                    title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px 24px;color:var(--muted);">
        <i class="fas fa-clipboard-list" style="font-size:36px;opacity:.2;display:block;margin-bottom:12px;"></i>
        <div style="font-size:14px;font-weight:500;">No meal records found.</div>
        <a href="{{ route('meals.create') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-size:13px;color:var(--gold);font-weight:600;text-decoration:none;">
            <i class="fas fa-plus"></i> Add your first meal
        </a>
    </div>
    @endforelse

    {{-- Footer --}}
    @if($meals->count())
    <div style="padding:13px 22px;background:#fafafa;border-top:1px solid #f1f5f9;font-size:12px;color:var(--muted);font-family:'DM Mono',monospace;">
        Showing {{ $meals->count() }} record(s)
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
.dash-orb { position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;animation:orbFloat 14s ease-in-out infinite alternate; }
.dash-orb-1 { width:460px;height:460px;background:radial-gradient(circle,rgba(200,149,42,.15) 0%,transparent 70%);top:-120px;right:40px; }
.dash-orb-2 { width:340px;height:340px;background:radial-gradient(circle,rgba(52,144,220,.12) 0%,transparent 70%);bottom:60px;left:40px;animation-delay:-7s; }
@keyframes orbFloat { 0%{transform:translate(0,0) scale(1)} 100%{transform:translate(20px,18px) scale(1.08)} }
.content { background: radial-gradient(ellipse 70% 50% at 10% 0%,rgba(200,149,42,.1) 0%,transparent 55%), radial-gradient(ellipse 60% 50% at 90% 100%,rgba(52,144,220,.08) 0%,transparent 55%), var(--cream); background-attachment:fixed; }
</style>
@endpush