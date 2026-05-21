@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Gradient Orbs --}}
<div class="dash-orb dash-orb-1"></div>
<div class="dash-orb dash-orb-2"></div>
<div class="dash-orb dash-orb-3"></div>

{{-- Page Header --}}
<div class="page-header" style="margin-bottom:32px;">
    <div>
        <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:1px;color:var(--navy);line-height:1;">Dashboard</h2>
        <p style="font-size:13px;color:var(--muted);margin-top:4px;font-family:'DM Mono',monospace;letter-spacing:.5px;">
            Inmate Food Management Overview
        </p>
    </div>
    <a href="{{ route('meals.create') }}" class="btn btn-gold" style="padding:11px 22px;font-size:14px;font-weight:600;letter-spacing:.3px;">
        <i class="fas fa-plus"></i> Add New Meal
    </a>
</div>

{{-- STAT CARDS --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:32px;">

    {{-- Total Meals --}}
    <div class="dash-stat-card" style="background:linear-gradient(135deg,#fff 0%,#fffaf0 60%,rgba(200,149,42,.08) 100%);border-radius:14px;border:1px solid var(--cream-dk);padding:24px;position:relative;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--gold);"></div>
        <div style="position:absolute;bottom:-20px;right:-10px;font-size:80px;opacity:.04;color:var(--navy);line-height:1;">
            <i class="fas fa-utensils"></i>
        </div>
        <div style="width:44px;height:44px;border-radius:10px;background:rgba(200,149,42,.12);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="fas fa-utensils" style="color:var(--gold);font-size:18px;"></i>
        </div>
        <div style="font-family:'Bebas Neue',sans-serif;font-size:48px;line-height:1;color:var(--navy);">{{ $totalMeals }}</div>
        <div style="font-size:13px;color:var(--muted);margin-top:6px;font-weight:500;">Total Meals Recorded</div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--cream-dk);">
            <a href="{{ route('meals.index') }}" style="font-size:12px;color:var(--gold);text-decoration:none;font-weight:600;letter-spacing:.3px;">
                View all meals <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>
    </div>

    {{-- Total Ingredients --}}
    <div class="dash-stat-card" style="background:linear-gradient(135deg,#fff 0%,#f4f7fb 60%,rgba(139,164,191,.12) 100%);border-radius:14px;border:1px solid var(--cream-dk);padding:24px;position:relative;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--steel);"></div>
        <div style="position:absolute;bottom:-20px;right:-10px;font-size:80px;opacity:.04;color:var(--navy);line-height:1;">
            <i class="fas fa-carrot"></i>
        </div>
        <div style="width:44px;height:44px;border-radius:10px;background:rgba(139,164,191,.15);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="fas fa-carrot" style="color:var(--steel);font-size:18px;"></i>
        </div>
        <div style="font-family:'Bebas Neue',sans-serif;font-size:48px;line-height:1;color:var(--navy);">{{ $totalIngredients }}</div>
        <div style="font-size:13px;color:var(--muted);margin-top:6px;font-weight:500;">Total Ingredients</div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--cream-dk);">
            <a href="{{ route('ingredients.index') }}" style="font-size:12px;color:var(--steel);text-decoration:none;font-weight:600;letter-spacing:.3px;">
                View all ingredients <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>
    </div>

    {{-- Total Weekly Cost --}}
    @php
        $weeklyTotal = 0;
        foreach(($schedule ?? []) as $dayMeals) {
            foreach($dayMeals as $meal) {
                $weeklyTotal += $meal->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit);
            }
        }
    @endphp
    <div class="dash-stat-card" style="background:linear-gradient(135deg,#e8f4fd 0%,#d0e8f8 60%,#bdddf5 100%);border-radius:14px;border:1px solid #a8d0ef;padding:24px;position:relative;overflow:hidden;box-shadow:0 2px 12px rgba(52,144,220,.12);transition:transform .2s,box-shadow .2s;">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#3490dc,#63b3ed);"></div>
        <div style="position:absolute;bottom:-20px;right:-10px;font-size:80px;opacity:.08;color:#1a6fa8;line-height:1;">
            <i class="fas fa-peso-sign"></i>
        </div>
        <div style="width:44px;height:44px;border-radius:10px;background:rgba(52,144,220,.15);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
            <i class="fas fa-peso-sign" style="color:#2177b8;font-size:18px;"></i>
        </div>
        <div style="font-family:'Bebas Neue',sans-serif;font-size:36px;line-height:1;color:#0d4f7a;letter-spacing:.5px;">
            ₱{{ number_format($weeklyTotal, 2) }}
        </div>
        <div style="font-size:13px;color:#2d7ab5;margin-top:6px;font-weight:500;">Weekly Food Cost</div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid rgba(52,144,220,.2);">
            <span style="font-size:12px;color:#1a6fa8;font-weight:600;letter-spacing:.3px;">
                <i class="fas fa-calendar-week" style="font-size:10px;"></i> This week's total
            </span>
        </div>
    </div>

</div>

{{-- WEEKLY SCHEDULE --}}
<div style="background:linear-gradient(160deg,#fff 0%,#fffcf6 100%);border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 16px rgba(0,0,0,.07);overflow:hidden;margin-bottom:28px;">

    <div style="padding:20px 24px;border-bottom:1px solid rgba(200,149,42,.15);display:flex;align-items:center;justify-content:space-between;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;border-radius:8px;background:rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-calendar-week" style="color:var(--gold);font-size:15px;"></i>
            </div>
            <div>
                <h3 style="font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:.5px;color:#fff;line-height:1;">Weekly Meal Schedule</h3>
                <p style="font-size:11px;color:var(--steel);margin-top:2px;font-family:'DM Mono',monospace;">Scroll horizontally to see all days</p>
            </div>
        </div>
        <a href="{{ route('meals.create') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-plus" style="font-size:11px;"></i> Add Meal
        </a>
    </div>

    <div style="padding:20px 24px;overflow-x:auto;">
        <div style="display:grid;grid-template-columns:repeat(7,minmax(150px,1fr));gap:10px;min-width:900px;">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
            @php
                $dayMeals = $schedule[$day] ?? collect();
                $dayCost  = $dayMeals->sum(fn($m) => $m->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit));
            @endphp
            <div style="border-radius:10px;overflow:hidden;border:1.5px solid var(--cream-dk);background:var(--cream);">

                {{-- Day Header — uniform for all days --}}
                <div style="background:linear-gradient(135deg,var(--gold) 0%,var(--gold-lt) 100%);padding:10px 12px;text-align:center;">
                    <div style="font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;color:var(--navy);">
                        {{ substr($day, 0, 3) }}
                    </div>
                </div>

                {{-- Day Body --}}
                <div style="padding:8px;">
                    @forelse($dayMeals as $meal)
                    <div style="background:#fff;border-radius:7px;padding:8px 10px;margin-bottom:6px;border-left:3px solid var(--gold);box-shadow:0 1px 4px rgba(0,0,0,.06);">
                        <div style="font-size:12px;font-weight:600;color:var(--navy);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $meal->meal_name }}
                        </div>
                        <div style="font-size:11px;color:var(--muted);">{{ $meal->quantity }} {{ $meal->unit }}</div>
                        @php
                            $mealCost = $meal->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit);
                        @endphp
                        @if($mealCost > 0)
                        <div style="font-size:10px;font-family:'DM Mono',monospace;color:#1A7A4A;font-weight:600;margin-top:3px;">
                            ₱{{ number_format($mealCost, 2) }}
                        </div>
                        @endif
                        <div style="display:flex;gap:4px;margin-top:6px;">
                            <a href="{{ route('meals.edit', $meal->id) }}" class="action-btn edit" title="Edit" style="width:26px;height:26px;font-size:11px;">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('meals.destroy', $meal->id) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" class="action-btn delete" onclick="confirmDelete(this.closest('form'))" title="Delete" style="width:26px;height:26px;font-size:11px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:20px 8px;">
                        <i class="fas fa-circle-plus" style="font-size:22px;color:var(--cream-dk);display:block;margin-bottom:6px;"></i>
                        <span style="font-size:11px;color:var(--muted);">No meal</span>
                    </div>
                    @endforelse

                    @if($dayCost > 0)
                    <div style="margin-top:4px;padding:5px 8px;background:rgba(200,149,42,.08);border-radius:5px;text-align:right;">
                        <span style="font-size:10px;font-family:'DM Mono',monospace;color:var(--gold);font-weight:600;">
                            ₱{{ number_format($dayCost, 2) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- BOTTOM ROW: Quick Actions + Cost Breakdown --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- Quick Actions --}}
    <div style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;">
        <div style="padding:18px 22px;border-bottom:1px solid var(--cream-dk);background:linear-gradient(120deg,#0B1D33 0%,#142947 100%);">
            <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:var(--gold);">Quick Actions</h3>
        </div>
        <div style="padding:18px 22px;display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('meals.create') }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:10px;background:var(--cream);border:1px solid var(--cream-dk);text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(200,149,42,.1)';this.style.borderColor='var(--gold)'"
               onmouseout="this.style.background='var(--cream)';this.style.borderColor='var(--cream-dk)'">
                <div style="width:38px;height:38px;border-radius:9px;background:rgba(200,149,42,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-plus" style="color:var(--gold);font-size:15px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--navy);">Add New Meal</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Plan a meal for the week</div>
                </div>
                <i class="fas fa-chevron-right" style="color:var(--muted);font-size:11px;margin-left:auto;"></i>
            </a>
            <a href="{{ route('meals.index') }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:10px;background:var(--cream);border:1px solid var(--cream-dk);text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(11,29,51,.06)';this.style.borderColor='var(--navy)'"
               onmouseout="this.style.background='var(--cream)';this.style.borderColor='var(--cream-dk)'">
                <div style="width:38px;height:38px;border-radius:9px;background:rgba(11,29,51,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-utensils" style="color:var(--navy);font-size:15px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--navy);">Meal Records</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">View and manage all meals</div>
                </div>
                <i class="fas fa-chevron-right" style="color:var(--muted);font-size:11px;margin-left:auto;"></i>
            </a>
            <a href="{{ route('ingredients.index') }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:10px;background:var(--cream);border:1px solid var(--cream-dk);text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(139,164,191,.12)';this.style.borderColor='var(--steel)'"
               onmouseout="this.style.background='var(--cream)';this.style.borderColor='var(--cream-dk)'">
                <div style="width:38px;height:38px;border-radius:9px;background:rgba(139,164,191,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-carrot" style="color:var(--steel);font-size:15px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--navy);">Ingredients</div>
                    <div style="font-size:11px;color:var(--muted);margin-top:1px;">Manage ingredient costs</div>
                </div>
                <i class="fas fa-chevron-right" style="color:var(--muted);font-size:11px;margin-left:auto;"></i>
            </a>
        </div>
    </div>

    {{-- Cost Breakdown by Day --}}
    <div style="background:linear-gradient(160deg,#fff 0%,#f5f8fc 100%);border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;">
        <div style="padding:18px 22px;border-bottom:1px solid var(--cream-dk);display:flex;align-items:center;justify-content:space-between;background:linear-gradient(120deg,#0B1D33 0%,#1E3A5F 100%);">
            <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:var(--gold);">Cost by Day</h3>
            <span style="font-size:11px;font-family:'DM Mono',monospace;color:var(--steel);">This week</span>
        </div>
        <div style="padding:16px 22px;">
            @php
                $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                $maxDayCost = collect($days)->map(fn($d) => collect($schedule[$d] ?? [])->sum(fn($m) => $m->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit)))->max() ?: 1;
            @endphp
            @foreach($days as $day)
            @php
                $dc  = collect($schedule[$day] ?? [])->sum(fn($m) => $m->ingredients->sum(fn($i) => (float)$i->quantity * (float)$i->price_per_unit));
                $pct = round(($dc / $maxDayCost) * 100);
            @endphp
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <span style="font-size:11px;font-weight:600;color:var(--muted);width:28px;font-family:'DM Mono',monospace;flex-shrink:0;">
                    {{ substr($day, 0, 3) }}
                </span>
                <div style="flex:1;height:8px;background:var(--cream-dk);border-radius:10px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:var(--navy);border-radius:10px;transition:width .6s ease;"></div>
                </div>
                <span style="font-size:11px;font-family:'DM Mono',monospace;color:var(--navy);font-weight:600;width:80px;text-align:right;flex-shrink:0;">
                    {{ $dc > 0 ? '₱'.number_format($dc,2) : '—' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
.content {
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%, rgba(200,149,42,.13) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 10%, rgba(11,29,51,.09) 0%, transparent 55%),
        radial-gradient(ellipse 70% 60% at 50% 100%, rgba(139,164,191,.12) 0%, transparent 60%),
        var(--cream);
    background-attachment: fixed;
}
.dash-stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.13) !important; }
.dash-orb { position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;animation:orbFloat 14s ease-in-out infinite alternate; }
.dash-orb-1 { width:500px;height:500px;background:radial-gradient(circle,rgba(200,149,42,.18) 0%,transparent 70%);top:-150px;right:60px; }
.dash-orb-2 { width:380px;height:380px;background:radial-gradient(circle,rgba(11,29,51,.12) 0%,transparent 70%);bottom:60px;left:60px;animation-delay:-6s; }
.dash-orb-3 { width:280px;height:280px;background:radial-gradient(circle,rgba(139,164,191,.18) 0%,transparent 70%);top:45%;right:20px;animation-delay:-10s; }
@keyframes orbFloat { 0%{transform:translate(0,0) scale(1)} 100%{transform:translate(25px,20px) scale(1.1)} }
.content > * { position:relative;z-index:1; }
</style>
@endpush