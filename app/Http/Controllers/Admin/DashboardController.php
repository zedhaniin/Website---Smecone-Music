<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Gallery;
use App\Models\Instrument;
use App\Models\MemberStructure;
use App\Models\Showcase;
use App\Models\StudioBooking;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'pendingUsers' => User::where('is_approved', false)->count(),
            'totalInstruments' => Instrument::count(),
            'availableInstruments' => Instrument::where('is_available', true)->count(),
            'pendingBorrowings' => Borrowing::where('status', 'pending')->count(),
            'approvedBorrowings' => Borrowing::where('status', 'approved')->count(),
            'pendingBookings' => StudioBooking::where('status', 'pending')->count(),
            'approvedBookings' => StudioBooking::where('status', 'approved')->count(),
            'totalGalleries' => Gallery::count(),
            'totalShowcases' => Showcase::count(),
            'totalMembers' => MemberStructure::count(),
            'recentBorrowings' => Borrowing::with(['user', 'instrument'])->latest()->take(5)->get(),
            'recentBookings' => StudioBooking::with('user')->latest()->take(5)->get(),
        ]);
    }
}
