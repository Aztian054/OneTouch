@extends('layouts.internal')
@section('title','Manajemen User')
@section('breadcrumb','Manajemen User')
@section('content')
<div class="page-header">
  <div><div class="page-title">Manajemen User</div><div class="page-subtitle">Total: {{ $users->total() }} akun</div></div>
  <a href="{{ route('admin.users.create') }}" class="btn btn-gold"><i class="fas fa-user-plus"></i> Tambah User</a>
</div>
<div class="card">
  <div class="card-body" style="padding-bottom:0">
    <form method="GET" class="filter-bar">
      <div class="search-wrap"><i class="fas fa-search"></i>
        <input type="text" name="search" class="form-control" placeholder="Cari nama / username..." value="{{ request('search') }}">
      </div>
      <select name="role" class="form-select">
        <option value="">Semua Role</option>
        <option value="admin"   {{ request('role')=='admin'?'selected':'' }}>Admin</option>
        <option value="officer" {{ request('role')=='officer'?'selected':'' }}>Officer</option>
        <option value="user"    {{ request('role')=='user'?'selected':'' }}>User</option>
      </select>
      <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-times"></i></a>
    </form>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>No</th><th>Nama</th><th>Username</th><th>Role</th><th>Perusahaan</th><th>Officer</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($users as $i => $u)
        <tr>
          <td>{{ $users->firstItem() + $i }}</td>
          <td>
            <div style="display:flex; align-items:center; gap:8px">
              <div style="width:30px;height:30px;border-radius:50%;background:var(--navy);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">
                {{ strtoupper(substr($u->name,0,1)) }}
              </div>
              <span style="font-weight:500">{{ $u->name }}</span>
            </div>
          </td>
          <td style="font-family:monospace;font-size:12px">{{ $u->username }}</td>
          <td><span class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
          <td style="font-size:13px; color:var(--text-muted)">{{ $u->company_name ?? '-' }}</td>
          <td style="font-size:13px; color:var(--text-muted)">{{ $u->officer?->name ?? '-' }}</td>
          <td><div style="display:flex;gap:4px">
            <a href="{{ route('admin.users.show',$u) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-primary btn-xs"><i class="fas fa-pen"></i></a>
            @if($u->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('Hapus user ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
            </form>
            @endif
          </div></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty-state"><i class="fas fa-users"></i><p>Belum ada user</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
  <div style="padding:16px 20px; border-top:1px solid var(--border)">{{ $users->links('vendor.pagination.custom') }}</div>
  @endif
</div>
@endsection
