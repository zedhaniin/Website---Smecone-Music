@extends('layouts.admin')

@section('page-title', 'Booking Studio Musik')
@section('page-description', 'Kelola permohonan booking Studio Musik (STM).')

@section('content')
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600">Pemohon</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Keperluan</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Waktu</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-right font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $booking->user->name }}</span>
                                </div>
                            </td>
                            <td class="max-w-xs truncate px-6 py-4 text-gray-700">{{ $booking->purpose }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <div class="text-xs">
                                    <div>{{ $booking->start_time->format('d M Y') }}</div>
                                    <div class="text-gray-400">{{ $booking->start_time->format('H:i') }} — {{ $booking->end_time->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $booking->status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($booking->status === 'pending')
                                        <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 transition-colors hover:bg-green-100">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition-colors hover:bg-red-100">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada permohonan booking studio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">{{ $bookings->links() }}</div>
        @endif
    </div>
@endsection
