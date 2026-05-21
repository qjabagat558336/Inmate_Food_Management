@extends('layouts.app')
@section('title', 'Profile')

@section('content')

{{-- Gradient Orbs --}}
<div class="dash-orb dash-orb-1"></div>
<div class="dash-orb dash-orb-2"></div>

{{-- Page Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:32px;position:relative;z-index:1;">
    <div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;">
            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--gold),var(--gold-lt));display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(200,149,42,.35);">
                <i class="fas fa-user-cog" style="color:#fff;font-size:16px;"></i>
            </div>
            <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:1px;color:var(--navy);line-height:1;">Profile Settings</h2>
        </div>
        <p style="color:var(--muted);font-size:13px;margin-top:2px;font-family:'DM Mono',monospace;letter-spacing:.3px;">Manage your account information and password.</p>
    </div>
</div>

@if(session('success'))
<div style="display:flex;align-items:center;gap:10px;padding:13px 18px;background:linear-gradient(135deg,rgba(26,122,74,.08),rgba(26,122,74,.03));border:1px solid rgba(26,122,74,.25);border-radius:10px;margin-bottom:20px;position:relative;z-index:1;">
    <i class="fas fa-check-circle" style="color:#1A7A4A;font-size:15px;flex-shrink:0;"></i>
    <span style="font-size:13.5px;color:#1A7A4A;font-weight:500;">{{ session('success') }}</span>
</div>
@endif

@if(session('password_success'))
<div style="display:flex;align-items:center;gap:10px;padding:13px 18px;background:linear-gradient(135deg,rgba(52,144,220,.08),rgba(52,144,220,.03));border:1px solid rgba(52,144,220,.25);border-radius:10px;margin-bottom:20px;position:relative;z-index:1;">
    <i class="fas fa-lock" style="color:#3490dc;font-size:15px;flex-shrink:0;"></i>
    <span style="font-size:13.5px;color:#3490dc;font-weight:500;">{{ session('password_success') }}</span>
</div>
@endif

<div style="display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;position:relative;z-index:1;">

    {{-- ── Left: Profile Card ── --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Avatar Card --}}
        <div style="background:#fff;border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;">
            {{-- Navy banner --}}
            <div style="background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);padding:32px 24px 24px;text-align:center;position:relative;border-bottom:3px solid var(--gold);">
                {{-- Decorative ring --}}
                <div style="position:absolute;top:-40px;right:-40px;width:140px;height:140px;border-radius:50%;background:rgba(200,149,42,.06);pointer-events:none;"></div>

                <div style="width:82px;height:82px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-lt));color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:30px;margin:0 auto 14px;border:3px solid rgba(255,255,255,.25);box-shadow:0 6px 20px rgba(200,149,42,.4);">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>

                <h3 style="color:#fff;font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:.5px;line-height:1;">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </h3>
                <p style="color:rgba(255,255,255,.5);font-size:12.5px;margin-top:5px;font-family:'DM Mono',monospace;">
                    {{ auth()->user()->email ?? '' }}
                </p>
                <span style="display:inline-block;margin-top:12px;padding:4px 14px;background:rgba(200,149,42,.2);color:var(--gold);border-radius:20px;font-size:11.5px;font-weight:600;letter-spacing:.3px;">
                    {{ auth()->user()->role ?? 'System Administrator' }}
                </span>
            </div>

            {{-- Stats --}}
            <div style="padding:6px 0;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 22px;border-bottom:1px solid var(--cream-dk);">
                    <div style="display:flex;align-items:center;gap:9px;font-size:13px;color:var(--muted);">
                        <i class="fas fa-clipboard-list" style="color:var(--gold);width:14px;text-align:center;"></i> Meals Added
                    </div>
                    <strong style="font-family:'DM Mono',monospace;font-size:14px;color:var(--navy);">{{ $totalMeals }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 22px;border-bottom:1px solid var(--cream-dk);">
                    <div style="display:flex;align-items:center;gap:9px;font-size:13px;color:var(--muted);">
                        <i class="fas fa-boxes-stacked" style="color:var(--gold);width:14px;text-align:center;"></i> Ingredients
                    </div>
                    <strong style="font-family:'DM Mono',monospace;font-size:14px;color:var(--navy);">{{ $totalIngredients }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 22px;">
                    <div style="display:flex;align-items:center;gap:9px;font-size:13px;color:var(--muted);">
                        <i class="fas fa-calendar-check" style="color:var(--gold);width:14px;text-align:center;"></i> Member Since
                    </div>
                    <strong style="font-family:'DM Mono',monospace;font-size:13px;color:var(--navy);">{{ auth()->user()->created_at->format('M Y') }}</strong>
                </div>
            </div>
        </div>

        {{-- Quick Links --}}
        <div style="background:#fff;border-radius:14px;border:1px solid var(--cream-dk);box-shadow:0 2px 10px rgba(0,0,0,.05);padding:18px 20px;">
            <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Quick Links</div>
            <a href="{{ route('meals.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;text-decoration:none;color:var(--navy);font-size:13.5px;font-weight:500;transition:background .2s;margin-bottom:4px;"
               onmouseover="this.style.background='#fffcf5'" onmouseout="this.style.background=''">
                <i class="fas fa-clipboard-list" style="color:var(--gold);width:16px;text-align:center;font-size:13px;"></i> Meal Records
            </a>
            <a href="{{ route('meals.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;text-decoration:none;color:var(--navy);font-size:13.5px;font-weight:500;transition:background .2s;margin-bottom:4px;"
               onmouseover="this.style.background='#fffcf5'" onmouseout="this.style.background=''">
                <i class="fas fa-plus-circle" style="color:var(--gold);width:16px;text-align:center;font-size:13px;"></i> Add Meal
            </a>
            <a href="{{ route('ingredients.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;text-decoration:none;color:var(--navy);font-size:13.5px;font-weight:500;transition:background .2s;"
               onmouseover="this.style.background='#fffcf5'" onmouseout="this.style.background=''">
                <i class="fas fa-boxes-stacked" style="color:var(--gold);width:16px;text-align:center;font-size:13px;"></i> Ingredients
            </a>
        </div>

    </div>

    {{-- ── Right: Forms ── --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Update Profile --}}
        <div style="background:linear-gradient(160deg,#fff 0%,#fffcf5 100%);border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;">
            <div style="padding:18px 26px;display:flex;align-items:center;gap:14px;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);border-bottom:3px solid var(--gold);">
                <div style="width:34px;height:34px;border-radius:8px;background:rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-user-edit" style="color:var(--gold);font-size:14px;"></i>
                </div>
                <div>
                    <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:#fff;line-height:1;">Update Profile</h3>
                    <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:1px;font-family:'DM Mono',monospace;">Change your name, email or role</p>
                </div>
            </div>
            <div style="padding:28px 26px;">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')

                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-user" style="color:var(--gold);font-size:11px;"></i>
                                Full Name <span style="color:var(--danger)">*</span>
                            </label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-envelope" style="color:var(--gold);font-size:11px;"></i>
                                Email Address <span style="color:var(--danger)">*</span>
                            </label>
                            <input type="email" name="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div style="height:1px;background:linear-gradient(90deg,transparent,var(--cream-dk),transparent);margin-bottom:20px;"></div>

                    <div class="form-group" style="margin-bottom:24px;">
                        <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                            <i class="fas fa-id-badge" style="color:var(--gold);font-size:11px;"></i>
                            Position / Role
                        </label>
                        <input type="text" name="role" class="form-control"
                            value="{{ old('role', auth()->user()->role ?? 'System Administrator') }}"
                            placeholder="e.g. Jail Warden">
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn btn-gold" style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div style="background:linear-gradient(160deg,#fff 0%,#f5f8fc 100%);border-radius:16px;border:1px solid var(--cream-dk);box-shadow:0 4px 20px rgba(0,0,0,.07);overflow:hidden;">
            <div style="padding:18px 26px;display:flex;align-items:center;gap:14px;background:linear-gradient(120deg,#0B1D33 0%,#142947 60%,#1E3A5F 100%);border-bottom:3px solid var(--gold);">
                <div style="width:34px;height:34px;border-radius:8px;background:rgba(200,149,42,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-lock" style="color:var(--gold);font-size:14px;"></i>
                </div>
                <div>
                    <h3 style="font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:.5px;color:#fff;line-height:1;">Change Password</h3>
                    <p style="font-size:11px;color:rgba(255,255,255,.4);margin-top:1px;font-family:'DM Mono',monospace;">Keep your account secure</p>
                </div>
            </div>
            <div style="padding:28px 26px;">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="form-group" style="margin-bottom:20px;">
                        <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                            <i class="fas fa-key" style="color:var(--gold);font-size:11px;"></i>
                            Current Password <span style="color:var(--danger)">*</span>
                        </label>
                        <div style="position:relative;">
                            <input type="password" name="current_password" id="cur_pwd"
                                class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                style="padding-right:42px;" required>
                            <button type="button" onclick="togglePwd('cur_pwd','eye1')"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        @error('current_password')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                    </div>

                    <div style="height:1px;background:linear-gradient(90deg,transparent,var(--cream-dk),transparent);margin-bottom:20px;"></div>

                    <div class="form-grid-2" style="margin-bottom:20px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-lock" style="color:var(--gold);font-size:11px;"></i>
                                New Password <span style="color:var(--danger)">*</span>
                            </label>
                            <div style="position:relative;">
                                <input type="password" name="password" id="new_pwd"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    style="padding-right:42px;" required>
                                <button type="button" onclick="togglePwd('new_pwd','eye2')"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;">
                                    <i class="fas fa-eye" id="eye2"></i>
                                </button>
                            </div>
                            @error('password')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-lock" style="color:var(--gold);font-size:11px;"></i>
                                Confirm Password <span style="color:var(--danger)">*</span>
                            </label>
                            <div style="position:relative;">
                                <input type="password" name="password_confirmation" id="conf_pwd"
                                    class="form-control"
                                    style="padding-right:42px;" required>
                                <button type="button" onclick="togglePwd('conf_pwd','eye3')"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;">
                                    <i class="fas fa-eye" id="eye3"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:linear-gradient(135deg,rgba(52,144,220,.06),rgba(52,144,220,.02));border:1px solid rgba(52,144,220,.18);border-radius:8px;margin-bottom:22px;">
                        <i class="fas fa-shield-alt" style="color:#3490dc;font-size:13px;flex-shrink:0;"></i>
                        <span style="font-size:12.5px;color:#2177b8;font-weight:500;">Password must be at least 8 characters long.</span>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;">
                            <i class="fas fa-lock"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
.dash-orb { position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;animation:orbFloat 14s ease-in-out infinite alternate; }
.dash-orb-1 { width:460px;height:460px;background:radial-gradient(circle,rgba(200,149,42,.15) 0%,transparent 70%);top:-120px;right:40px; }
.dash-orb-2 { width:340px;height:340px;background:radial-gradient(circle,rgba(52,144,220,.12) 0%,transparent 70%);bottom:60px;left:40px;animation-delay:-7s; }
@keyframes orbFloat { 0%{transform:translate(0,0) scale(1)} 100%{transform:translate(20px,18px) scale(1.08)} }
.content { background: radial-gradient(ellipse 70% 50% at 10% 0%,rgba(200,149,42,.1) 0%,transparent 55%), radial-gradient(ellipse 60% 50% at 90% 100%,rgba(52,144,220,.08) 0%,transparent 55%), var(--cream); background-attachment:fixed; }
.form-control:focus { border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(200,149,42,.12) !important; }
</style>
@endpush

@push('scripts')
<script>
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
@endpush