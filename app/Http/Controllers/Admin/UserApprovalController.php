<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('status', 'pending')->with('kelas');

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $pendingUsers = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.approval.index', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        ActivityLog::record('APPROVE', 'Approval Akun', "Menyetujui akun: {$user->name}", $user);

        return redirect()->route('admin.approval.index')
            ->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        ActivityLog::record('REJECT', 'Approval Akun', "Menolak akun: {$user->name}", $user);

        return redirect()->route('admin.approval.index')
            ->with('success', "Akun {$user->name} ditolak.");
    }
}