@extends('layouts.internal')
@section('title','Detail User')
@section('breadcrumb','Detail User')
@section('content')
<div class="page-header">
  <div><div class="page-title">Detail User</div><div class="page-subtitle">{{ $user->username }}</div></div>
  <div style="display:flex;gap:8px">
    <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>
<div class="card" style="max-width:680px">
  <div class="card-header">
    <span class="card-title">Informasi Akun</span>
    <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
  </div>
  <div class="card-body">
    <div class="detail-grid">
      <div class="detail-label">Nama</div><div class="detail-value">{{ $user->name }}</div>
      <div class="detail-label">Username</div><div class="detail-value" style="font-family:monospace">{{ $user->username }}</div>
      <div class="detail-label">Email</div><div class="detail-value">{{ $user->email ?? '-' }}</div>
      <div class="detail-label">Role</div><div class="detail-value"><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></div>
      <div class="detail-label">Perusahaan</div><div class="detail-value">{{ $user->company_name ?? '-' }}</div>
      <div class="detail-label">Officer</div><div class="detail-value">{{ $user->officer?->name ?? '-' }}</div>
      <div class="detail-label">Bergabung</div><div class="detail-value">{{ $user->created_at?->format('d F Y') }}</div>
    </div>
    @if($user->role === 'officer' && $user->managedUsers->count())
    <div style="margin-top:20px">
      <div style="font-weight:600; font-size:14px; margin-bottom:10px; color:var(--text)">User yang Dikelola ({{ $user->managedUsers->count() }})</div>
      @foreach($user->managedUsers as $mu)
      <div style="display:flex; align-items:center; gap:8px; padding:8px 0; border-bottom:1px solid var(--border)">
        <div style="width:28px;height:28px;border-radius:50%;background:var(--navy);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700">
          {{ strtoupper(substr($mu->name,0,1)) }}
        </div>
        <div>
          <div style="font-size:13.5px; font-weight:500; color:var(--text)">{{ $mu->name }}</div>
          <div style="font-size:11.5px; color:var(--text-muted)">{{ $mu->company_name }}</div>
        </div>
        <a href="{{ route('admin.users.show',$mu) }}" class="btn btn-outline btn-xs" style="margin-left:auto">Detail</a>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endsection
