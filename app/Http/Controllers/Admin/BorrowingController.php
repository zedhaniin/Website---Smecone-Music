<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(): View
    {
        return view('admin.borrowings.index', [
            'borrowings' => Borrowing::with(['user', 'instrument'])->latest()->paginate(15),
        ]);
    }

    public function approve(Borrowing $borrowing): RedirectResponse
    {
        $borrowing->update(['status' => 'approved']);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Borrowing $borrowing): RedirectResponse
    {
        $borrowing->update(['status' => 'rejected']);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function returned(Borrowing $borrowing): RedirectResponse
    {
        $borrowing->update(['status' => 'returned']);

        return back()->with('success', 'Alat berhasil ditandai sebagai dikembalikan.');
    }
}
