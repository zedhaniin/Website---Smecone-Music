<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Instrument;
use App\Models\StudioBooking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();

        // Approved studio bookings
        $approvedBookings = StudioBooking::where('status', 'approved')
            ->with('user')
            ->get()
            ->map(fn (StudioBooking $b) => [
                'title' => '[Studio] '.$b->purpose.' ('.$b->user->name.')',
                'start' => $b->start_time->toIso8601String(),
                'end' => $b->end_time->toIso8601String(),
                'color' => '#6C5CE7',
            ]);

        // Approved instrument borrowings
        $approvedBorrowings = Borrowing::where('status', 'approved')
            ->with(['user', 'instrument'])
            ->get()
            ->map(fn (Borrowing $b) => [
                'title' => '[Alat] '.$b->instrument->name.' ('.$b->user->name.')',
                'start' => $b->start_date->format('Y-m-d'),
                'end' => $b->end_date->copy()->addDay()->format('Y-m-d'),
                'color' => '#10B981',
            ]);

        $events = $approvedBookings->concat($approvedBorrowings)->values();

        return view('user.dashboard', [
            'borrowings' => $user->borrowings()->with('instrument')->latest()->get(),
            'bookings' => $user->studioBookings()->latest()->get(),
            'events' => $events,
        ]);
    }

    public function createBorrowing(): View
    {
        return view('user.borrowings.create', [
            'instruments' => Instrument::where('is_available', true)->get(),
        ]);
    }

    public function storeBorrowing(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instrument_id' => ['required', 'exists:instruments,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'permission_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $instrument = Instrument::findOrFail($validated['instrument_id']);

        if (! $instrument->hasAvailableStock()) {
            return back()->with('error', 'Alat musik tidak tersedia untuk dipinjam saat ini.');
        }

        $path = $request->file('permission_letter')->store('permission-letters', 'public');

        Borrowing::create([
            'user_id' => auth()->id(),
            'instrument_id' => $validated['instrument_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'permission_letter_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan Admin/Perkap.');
    }

    public function createBooking(): View
    {
        return view('user.bookings.create');
    }

    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'purpose' => ['required', 'string', 'max:500'],
        ]);

        $booking = new StudioBooking($validated);
        $booking->user_id = auth()->id();
        $booking->status = 'pending';

        if ($booking->overlapsWithApproved()) {
            return back()->with('error', 'Jadwal yang dipilih bentrok dengan booking yang sudah disetujui. Silakan pilih waktu lain.');
        }

        $booking->save();

        return redirect()->route('user.dashboard')->with('success', 'Permintaan booking studio berhasil dikirim. Menunggu persetujuan Admin/Perkap.');
    }

    public function bookingCalendar(): View
    {
        return $this->index();
    }
}
