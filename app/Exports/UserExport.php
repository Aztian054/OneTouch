<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = User::query()->with('officer');

        // Apply filters
        if (!empty($this->filters['role'])) {
            $query->where('role', $this->filters['role']);
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('username', 'like', "%$search%");
            });
        }

        if (!empty($this->filters['tahun'])) {
            $query->whereYear('created_at', $this->filters['tahun']);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Username',
            'Email',
            'Role',
            'Nama Perusahaan',
            'Petugas Penanggung Jawab',
            'Status Aktif',
            'Tanggal Dibuat',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->username,
            $user->email ?? '-',
            ucfirst($user->role),
            $user->company_name ?? '-',
            $user->officer ? $user->officer->name : '-',
            $user->is_active ?? true ? 'Aktif' : 'Nonaktif',
            $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan User';
    }
}