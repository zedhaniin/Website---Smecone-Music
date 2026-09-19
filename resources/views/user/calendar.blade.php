@extends('layouts.admin')

@section('page-title', 'Kalender Booking Studio')
@section('page-description', 'Lihat jadwal pemakaian Studio Musik (STM) yang sudah disetujui.')

@section('content')
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <div id="calendar"></div>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-brand-600 transition-colors hover:text-brand-700">
            ← Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">
                <span class="h-3 w-3 rounded-full bg-brand-500"></span> Jadwal Terpakai
            </span>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        .fc-toolbar-title { font-size: 1.1rem !important; font-weight: 700 !important; }
        .fc-button-primary { background-color: oklch(0.55 0.24 285) !important; border-color: oklch(0.48 0.26 285) !important; font-size: 0.8rem !important; }
        .fc-button-primary:hover { background-color: oklch(0.48 0.26 285) !important; }
        .fc-event { border-radius: 6px !important; padding: 2px 6px !important; font-size: 0.75rem !important; }
        .fc-daygrid-day-number { font-size: 0.85rem; font-weight: 500; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: @json($events),
                eventColor: 'oklch(0.55 0.24 285)',
                height: 'auto',
            });
            calendar.render();
        });
    </script>
@endpush
