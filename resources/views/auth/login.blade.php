<!DOCTYPE html>
<html lang="id" id="loginHtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — ONE TOUCH Balai PPMHKP Lampung</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --navy:     #0f172a;
  --navy-800: #1e293b;
  --gold:     #d4af37;
  --gold-d:   #b8960a;
  --surface:  #ffffff;
  --surface-2:#f8fafc;
  --border:   #e2e8f0;
  --text:     #1e293b;
  --muted:    #64748b;
  --danger:   #ef4444;
}
html.dark {
  --surface:  #1e293b;
  --surface-2:#0f172a;
  --border:   #334155;
  --text:     #f1f5f9;
  --muted:    #94a3b8;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Inter', sans-serif;
  background: var(--navy);
  min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  position: relative; overflow: hidden;
}
/* Background pattern */
body::before {
  content: '';
  position: fixed; inset: 0;
  background: url("{{ asset('assets/bg-dark.jpg') }}") center/cover;
  opacity: .05;
  pointer-events: none;
}
body::after {
  content: '';
  position: fixed; inset: 0;
  background: radial-gradient(ellipse at 30% 50%, rgba(212,175,55,.08) 0%, transparent 60%),
              radial-gradient(ellipse at 70% 20%, rgba(30,58,95,.5) 0%, transparent 60%);
  pointer-events: none;
}

/* ── CARD ── */
.login-card {
  width: 100%; max-width: 420px;
  background: var(--surface);
  border-radius: 16px;
  border: 1px solid var(--border);
  box-shadow: 0 20px 60px rgba(0,0,0,.25);
  overflow: hidden;
  position: relative; z-index: 1;
}

/* ── CARD HEADER ── */
.login-header {
  background: var(--navy);
  padding: 32px 32px 28px;
  text-align: center;
  border-bottom: 3px solid var(--gold);
  position: relative;
}
.login-header::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(circle at 50% 100%, rgba(212,175,55,.08) 0%, transparent 70%);
}
.login-logo {
  display: flex; align-items: center; justify-content: center; gap: 12px;
  margin-bottom: 16px; position: relative;
}
.login-logo img { height: 48px; width: auto; object-fit: contain; }
.login-logo-divider {
  width: 1px; height: 36px; background: rgba(255,255,255,.2);
}
.login-title {
  font-size: 22px; font-weight: 800; color: #fff;
  letter-spacing: .5px; position: relative;
}
.login-title span { color: var(--gold); }
.login-subtitle {
  font-size: 12px; color: rgba(255,255,255,.5);
  margin-top: 4px; position: relative;
}

/* ── CARD BODY ── */
.login-body { padding: 28px 32px 32px; }

/* ── FORM ELEMENTS ── */
.form-group { margin-bottom: 18px; }
.form-label {
  display: block; font-size: 13px; font-weight: 500;
  color: var(--text); margin-bottom: 6px;
}
.input-wrap { position: relative; }
.input-wrap .input-icon {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
  color: var(--muted); font-size: 14px; pointer-events: none;
}
.form-control {
  width: 100%; padding: 10px 12px 10px 38px;
  border-radius: 9px; border: 1.5px solid var(--border);
  background: var(--surface-2); color: var(--text);
  font-family: inherit; font-size: 14px;
  transition: all .18s;
}
.form-control:focus {
  outline: none; border-color: var(--gold);
  background: var(--surface);
  box-shadow: 0 0 0 3px rgba(212,175,55,.15);
}
.form-control::placeholder { color: var(--muted); }
.toggle-pw {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  background: none; border: none; cursor: pointer;
  color: var(--muted); font-size: 14px; padding: 2px;
  transition: color .15s;
}
.toggle-pw:hover { color: var(--text); }
.form-error {
  font-size: 12px; color: var(--danger); margin-top: 5px;
  display: flex; align-items: center; gap: 4px;
}
.form-error i { font-size: 11px; }

/* ── REMEMBER ME ── */
.remember-row {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 22px;
}
.remember-row input[type="checkbox"] {
  width: 16px; height: 16px; cursor: pointer;
  accent-color: var(--gold);
}
.remember-row label { font-size: 13px; color: var(--muted); cursor: pointer; }

/* ── SUBMIT BTN ── */
.btn-submit {
  width: 100%; padding: 12px;
  background: var(--navy); color: #fff;
  border: none; border-radius: 9px;
  font-family: inherit; font-size: 15px; font-weight: 600;
  cursor: pointer; letter-spacing: .3px;
  transition: background .18s, transform .1s;
  display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-submit:hover { background: var(--navy-800); }
.btn-submit:active { transform: scale(.99); }

/* ── DIVIDER ── */
.login-divider {
  display: flex; align-items: center; gap: 12px;
  margin: 20px 0;
}
.login-divider::before, .login-divider::after {
  content: ''; flex: 1; height: 1px; background: var(--border);
}
.login-divider span { font-size: 12px; color: var(--muted); }

/* ── PORTAL LINK ── */
.portal-link {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  padding: 10px;
  border: 1.5px solid var(--border); border-radius: 9px;
  color: var(--muted); text-decoration: none; font-size: 13px;
  transition: all .18s;
}
.portal-link:hover { border-color: var(--gold); color: var(--gold); }

/* ── THEME TOGGLE ── */
.theme-toggle {
  position: fixed; top: 20px; right: 20px; z-index: 10;
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
  color: rgba(255,255,255,.7); cursor: pointer; font-size: 15px;
  transition: all .18s;
}
.theme-toggle:hover { background: rgba(255,255,255,.18); color: #fff; }

/* ── ALERT ── */
.alert {
  padding: 10px 14px; border-radius: 8px; margin-bottom: 18px;
  font-size: 13px; display: flex; align-items: flex-start; gap: 8px;
}
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

/* ── DARK ADJUSTMENTS ── */
html.dark .login-card {
  box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
html.dark .form-control {
  background: rgba(255,255,255,.05);
}
</style>
</head>
<body>

<button class="theme-toggle" onclick="toggleTheme()" id="themeBtn">
  <i class="fas fa-moon" id="themeIcon"></i>
</button>

<div class="login-card">
  <div class="login-header">
    <div class="login-logo">
      <img src="{{ asset('assets/header-logo1-kkp.png') }}" alt="KKP">
      <div class="login-logo-divider"></div>
      <img src="{{ asset('assets/header-logo2-bppmhkp.png') }}" alt="BPPMHKP">
    </div>
    <div class="login-title">ONE <span>TOUCH</span></div>
    <div class="login-subtitle">Sistem Layanan Balai PPMHKP Lampung</div>
  </div>

  <div class="login-body">

    @if(session('success'))
    <div class="alert alert-success">
      <i class="fas fa-circle-check"></i>
      {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
      <i class="fas fa-circle-xmark"></i>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf

      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <div class="input-wrap">
          <i class="fas fa-user input-icon"></i>
          <input
            type="text"
            id="username"
            name="username"
            class="form-control"
            placeholder="Masukkan username"
            value="{{ old('username') }}"
            autocomplete="username"
            autofocus
          >
        </div>
        @error('username')
        <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            placeholder="Masukkan password"
            autocomplete="current-password"
          >
          <button type="button" class="toggle-pw" onclick="togglePw()" id="pwToggle">
            <i class="fas fa-eye" id="pwIcon"></i>
          </button>
        </div>
        @error('password')
        <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
        @enderror
      </div>

      <div class="remember-row">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember">Ingat saya</label>
      </div>

      <button type="submit" class="btn-submit">
        <i class="fas fa-right-to-bracket"></i>
        Masuk ke Sistem
      </button>
    </form>

    <div class="login-divider"><span>atau</span></div>

    <a href="{{ route('beranda') }}" class="portal-link">
      <i class="fas fa-globe"></i>
      Kunjungi Portal Publik
    </a>

  </div>
</div>

<script>
// Theme init
(function(){
  const t = localStorage.getItem('onetouchTheme') || 'light';
  document.getElementById('loginHtml').className = t;
  const icon = document.getElementById('themeIcon');
  if(icon) icon.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
})();

function toggleTheme(){
  const html = document.getElementById('loginHtml');
  const isDark = html.classList.contains('dark');
  const next = isDark ? 'light' : 'dark';
  html.className = next;
  localStorage.setItem('onetouchTheme', next);
  document.getElementById('themeIcon').className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

// Password toggle
function togglePw(){
  const input = document.getElementById('password');
  const icon  = document.getElementById('pwIcon');
  if(input.type === 'password'){
    input.type = 'text';
    icon.className = 'fas fa-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'fas fa-eye';
  }
}
</script>
</body>
</html>
