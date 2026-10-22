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

    public function instruments(Request $request): View
    {
        $query = Instrument::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $allInstruments = Instrument::withCount(['borrowings as active_borrowings_count' => function ($query) {
            $query->where('status', 'approved');
        }])->get();

        $totalCount = $allInstruments->count();
        $availableCount = $allInstruments->filter(fn (Instrument $i) => $i->is_available && ($i->quantity - $i->active_borrowings_count) > 0)->count();
        $borrowedCount = $allInstruments->filter(fn (Instrument $i) => $i->active_borrowings_count > 0)->count();

        $instruments = $query->withCount(['borrowings as active_borrowings_count' => function ($query) {
            $query->where('status', 'approved');
        }])->latest()->get();

        $statusFilter = $request->input('status', 'all');
        if ($statusFilter === 'available') {
            $instruments = $instruments->filter(fn (Instrument $i) => $i->is_available && ($i->quantity - $i->active_borrowings_count) > 0);
        } elseif ($statusFilter === 'borrowed') {
            $instruments = $instruments->filter(fn (Instrument $i) => $i->active_borrowings_count > 0);
        }

        return view('user.instruments.index', [
            'instruments' => $instruments,
            'totalCount' => $totalCount,
            'availableCount' => $availableCount,
            'borrowedCount' => $borrowedCount,
            'search' => $request->input('search'),
            'selectedStatus' => $statusFilter,
        ]);
    }

    public function borrowings(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();

        $query = $user->borrowings()->with('instrument');

        $statusFilter = $request->input('status', 'all');
        if ($request->filled('status') && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $borrowings = $query->latest()->get();

        $allBorrowings = $user->borrowings()->get();
        $counts = [
            'all' => $allBorrowings->count(),
            'pending' => $allBorrowings->where('status', 'pending')->count(),
            'approved' => $allBorrowings->where('status', 'approved')->count(),
            'returned' => $allBorrowings->where('status', 'returned')->count(),
            'rejected' => $allBorrowings->where('status', 'rejected')->count(),
        ];

        return view('user.borrowings.index', [
            'borrowings' => $borrowings,
            'counts' => $counts,
            'selectedStatus' => $statusFilter,
        ]);
    }

    public function bookings(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();

        $query = $user->studioBookings();

        $statusFilter = $request->input('status', 'all');
        if ($request->filled('status') && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $bookings = $query->latest()->get();

        $allBookings = $user->studioBookings()->get();
        $counts = [
            'all' => $allBookings->count(),
            'pending' => $allBookings->where('status', 'pending')->count(),
            'approved' => $allBookings->where('status', 'approved')->count(),
            'rejected' => $allBookings->where('status', 'rejected')->count(),
        ];

        // Approved studio bookings for the room calendar
        $events = StudioBooking::where('status', 'approved')
            ->with('user')
            ->get()
            ->map(fn (StudioBooking $b) => [
                'title' => '[Studio] '.$b->purpose.' ('.$b->user->name.')',
                'start' => $b->start_time->toIso8601String(),
                'end' => $b->end_time->toIso8601String(),
                'color' => '#6C5CE7',
            ]);

        return view('user.bookings.index', [
            'bookings' => $bookings,
            'counts' => $counts,
            'events' => $events,
            'selectedStatus' => $statusFilter,
        ]);
    }

    public function createBorrowing(): View
    {
        return view('user.borrowings.create', [
            'instruments' => Instrument::where('is_available', true)
                ->withCount(['borrowings as active_borrowings_count' => function ($query) {
                    $query->where('status', 'approved');
                }])
                ->get(),
        ]);
    }

    public function storeBorrowing(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instrument_ids' => ['required', 'array', 'min:1'],
            'instrument_ids.*' => ['required', 'exists:instruments,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'permission_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'instrument_ids.required' => 'Silakan pilih minimal 1 alat musik yang ingin dipinjam.',
            'instrument_ids.min' => 'Silakan pilih minimal 1 alat musik yang ingin dipinjam.',
        ]);

        $instruments = Instrument::whereIn('id', $validated['instrument_ids'])->get();

        // Check stock availability for all selected instruments
        $unavailable = $instruments->filter(fn (Instrument $i) => ! $i->hasAvailableStock());
        if ($unavailable->isNotEmpty()) {
            $names = $unavailable->pluck('name')->join(', ');

            return back()
                ->withInput()
                ->with('error', "Alat musik berikut sedang tidak tersedia untuk dipinjam: {$names}");
        }

        $letterPath = $request->file('permission_letter')->store('permission-letters', 'public');

        foreach ($instruments as $instrument) {
            Borrowing::create([
                'user_id' => auth()->id(),
                'instrument_id' => $instrument->id,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'permission_letter_path' => $letterPath,
                'status' => 'pending',
            ]);
        }

        $count = $instruments->count();

        return redirect()->route('user.dashboard')
            ->with('success', "Permintaan peminjaman untuk {$count} alat musik berhasil dikirim. Menunggu persetujuan Admin.");
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
            'permission_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $letterPath = $request->file('permission_letter')->store('permission-letters-studio', 'public');

        $booking = new StudioBooking([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose' => $validated['purpose'],
            'permission_letter_path' => $letterPath,
        ]);
        $booking->user_id = auth()->id();
        $booking->status = 'pending';

        if ($booking->overlapsWithApproved()) {
            return back()->withInput()->with('error', 'Jadwal yang dipilih bentrok dengan booking yang sudah disetujui. Silakan pilih waktu lain.');
        }

        $booking->save();

        return redirect()->route('user.dashboard')->with('success', 'Permintaan booking studio berhasil dikirim beserta surat izin. Menunggu persetujuan Admin.');
    }

    public function bookingCalendar(): View
    {
        return $this->index();
    }
}
