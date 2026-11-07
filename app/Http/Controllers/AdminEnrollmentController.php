<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEnrollmentController extends Controller
{
    private function checkAccess()
    {
        $role = Auth::user()->role ?? '';
        if ($role !== 'admin' && $role !== 'instructor') {
            abort(403, 'Akses khusus Admin / Instruktur.');
        }
    }

    public function index(Request $request)
    {
        $this->checkAccess();

        $query = Enrollment::with(['user', 'course']);

        if ($request->has('status') && in_array($request->status, ['pending', 'active'])) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->latest()->get();

        $pendingCount = Enrollment::where('status', 'pending')->count();
        $activeCount = Enrollment::where('status', 'active')->count();

        return view('admin.enrollments.index', compact('enrollments', 'pendingCount', 'activeCount'));
    }

    public function approve(Enrollment $enrollment)
    {
        $this->checkAccess();

        $enrollment->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Pendaftaran siswa atas nama "' . $enrollment->user->name . '" berhasil disetujui (Active)!');
    }

    public function reject(Enrollment $enrollment)
    {
        $this->checkAccess();

        $enrollment->delete();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan / ditolak.');
    }
}
