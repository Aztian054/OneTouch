@extends('layouts.internal')
@section('title','Edit User')
@section('breadcrumb','Edit User')
@section('content')
<div class="page-header">
  <div><div class="page-title">Edit User</div><div class="page-subtitle">{{ $user->username }}</div></div>
  <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card" style="max-width:700px">
  <div class="card-header"><span class="card-title">Edit Data Pengguna</span></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.users.update',$user) }}">
      @csrf @method('PUT')
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nama Lengkap <span class="req">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Username <span class="req">*</span></label>
          <input type="text" name="username" class="form-control" value="{{ old('username',$user->username) }}" required>
          @error('username')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Password Baru <span style="color:var(--text-muted); font-weight:400">(kosongkan jika tidak diubah)</span></label>
          <input type="password" name="password" class="form-control">
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Role <span class="req">*</span></label>
          <select name="role" class="form-select" id="roleSelect" onchange="toggleOfficerField()" required>
            <option value="user"    {{ old('role',$user->role)=='user'?'selected':'' }}>User</option>
            <option value="officer" {{ old('role',$user->role)=='officer'?'selected':'' }}>Officer</option>
            <option value="admin"   {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Nama Perusahaan</label>
        <input type="text" name="company_name" class="form-control" value="{{ old('company_name',$user->company_name) }}">
      </div>
      <div class="form-group" id="officerField">
        <label class="form-label">Assign Officer</label>
        <select name="officer_id" class="form-select">
          <option value="">-- Tidak Ada --</option>
          @foreach($officers as $o)
          <option value="{{ $o->id }}" {{ old('officer_id',$user->officer_id)==$o->id?'selected':'' }}>{{ $o->name }}</option>
          @endforeach
        </select>
      </div>
      <div style="display:flex; gap:10px">
        <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@push('scripts')
<script>
function toggleOfficerField(){
  const role = document.getElementById('roleSelect').value;
  document.getElementById('officerField').style.display = role==='user' ? 'block' : 'none';
}
toggleOfficerField();
</script>
@endpush
@endsection
