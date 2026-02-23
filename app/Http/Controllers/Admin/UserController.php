<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%$q%")
                   ->orWhere('username', 'like', "%$q%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users   = $query->with('officer')->latest()->paginate(15)->appends(request()->query());
        $officers = User::where('role', 'officer')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'officers'));
    }

    public function create()
    {
        $officers = User::where('role', 'officer')->orderBy('name')->get();
        return view('admin.users.create', compact('officers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:users',
            'email'        => 'nullable|email|unique:users',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|in:admin,officer,user',
            'company_name' => 'nullable|string|max:255',
            'officer_id'   => 'nullable|exists:users,id',
        ]);

        $data['password'] = Hash::make($data['password']);

        // officer_id only valid for users
        if ($data['role'] !== 'user') {
            $data['officer_id'] = null;
        }

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('officer', 'managedUsers');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $officers = User::where('role', 'officer')->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'officers'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'        => 'nullable|email|unique:users,email,' . $user->id,
            'password'     => 'nullable|string|min:6|confirmed',
            'role'         => 'required|in:admin,officer,user',
            'company_name' => 'nullable|string|max:255',
            'officer_id'   => 'nullable|exists:users,id',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($data['role'] !== 'user') {
            $data['officer_id'] = null;
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function assignOfficer(Request $request, User $user)
    {
        $request->validate([
            'officer_id' => 'nullable|exists:users,id',
        ]);

        if ($user->role !== 'user') {
            return back()->with('error', 'Hanya user dengan role "user" yang dapat di-assign officer.');
        }

        $user->update(['officer_id' => $request->officer_id]);
        return back()->with('success', 'Officer berhasil di-assign.');
    }

    public function exportPdf(Request $request)
    {
        $query = User::query()->with('officer');

        // Apply filters
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%$q%")
                   ->orWhere('username', 'like', "%$q%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $users = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.users', compact('users'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-users-' . now()->format('Ymd') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new UserExport($request->all()),
            'laporan-users-' . now()->format('Ymd') . '.xlsx'
        );
    }
}
