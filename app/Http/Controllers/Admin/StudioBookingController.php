<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudioBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudioBookingController extends Controller
{
    public function index(): View
    {
        return view('admin.bookings.index', [
            'bookings' => StudioBooking::with('user')->latest()->paginate(15),
        ]);
    }

    public function approve(StudioBooking $booking): RedirectResponse
    {
        if ($booking->overlapsWithApproved()) {
            return back()->with('error', 'Jadwal bentrok dengan booking yang sudah disetujui.');
        }

        $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking studio berhasil disetujui.');
    }

    public function reject(StudioBooking $booking): RedirectResponse
    {
        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking studio berhasil ditolak.');
    }
}
