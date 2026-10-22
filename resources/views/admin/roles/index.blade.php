@extends('layouts.admin')

@section('title', 'Manajemen Role & Hak Akses')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <svg class="h-6 w-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Manajemen Role & Hak Akses Pengurus</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Atur izin fitur untuk setiap role pengurus Smecone Music secara fleksibel via tombol atau drag & drop.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3.5 py-1 text-xs font-extrabold text-amber-800 border border-amber-200">
                <svg class="h-3.5 w-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Akses Khusus: Ketua & Wakil</span>
            </span>
        </div>
    </div>

    {{-- Role Selector Tabs --}}
    <div class="mb-6 rounded-3xl border border-slate-200/80 bg-white p-3 shadow-sm">
        <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 px-3 pt-1 pb-2">Pilih Role Pengurus yang Ingin Dikelola:</p>
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            @foreach($roles as $roleItem)
                @php
                    $isSelected = $roleItem->slug === $selectedRole->slug;
                @endphp
                <a href="{{ route('admin.roles.index', ['role' => $roleItem->slug]) }}" 
                   class="tap-press whitespace-nowrap rounded-2xl px-4 py-2.5 text-xs font-extrabold transition-all duration-200 flex items-center gap-2 shrink-0
                       {{ $isSelected 
                           ? 'bg-brand-950 text-white shadow-lg shadow-brand-950/20' 
                           : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/70' }}">
                    @if($roleItem->isSuperAdmin())
                        <svg class="h-3.5 w-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 011.082.164 1 1 0 01.328 1.047l-.8 2.399 2.115 1.41a1 1 0 010 1.664l-2.115 1.41.8 2.399a1 1 0 01-1.41 1.211l-1.599-.8L11 16.677V18a1 1 0 11-2 0v-1.323l-3.954-1.582-1.599.8a1 1 0 01-1.41-1.211l.8-2.399-2.115-1.41a1 1 0 010-1.664l2.115-1.41-.8-2.399a1 1 0 011.41-1.211l1.599.8L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                    @endif
                    <span>{{ $roleItem->name }}</span>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ $isSelected ? 'bg-white/20 text-white' : 'bg-slate-200/80 text-slate-500' }}">
                        {{ $roleItem->group }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Main Working Area --}}
    @if($selectedRole->isSuperAdmin())
        {{-- Super Admin Information Banner --}}
        <div class="rounded-3xl border border-amber-200/90 bg-gradient-to-br from-amber-50 via-white to-amber-50/40 p-8 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-md shadow-amber-500/30">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 011.082.164 1 1 0 01.328 1.047l-.8 2.399 2.115 1.41a1 1 0 010 1.664l-2.115 1.41.8 2.399a1 1 0 01-1.41 1.211l-1.599-.8L11 16.677V18a1 1 0 11-2 0v-1.323l-3.954-1.582-1.599.8a1 1 0 01-1.41-1.211l.8-2.399-2.115-1.41a1 1 0 010-1.664l2.115-1.41-.8-2.399a1 1 0 011.41-1.211l1.599.8L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-amber-950">Role {{ $selectedRole->name }} adalah Super Admin (Pengurus Inti)</h3>
                    <p class="mt-1 text-xs text-amber-800 leading-relaxed max-w-2xl">
                        Role ini secara otomatis memiliki <strong>seluruh hak akses (Full Access)</strong> pada setiap modul di Smecone Music, termasuk wewenang mengubah hak akses role lain. Hak akses Super Admin bersifat permanen demi menjaga stabilitas dan integritas sistem.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($allPermissions as $groupName => $perms)
                            <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-3 py-1.5 text-[11px] font-bold text-amber-900 border border-amber-200/80 shadow-2xs">
                                <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ $groupName }} (Full)</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Interactive Dual Box (Available vs Assigned) with Drag & Drop & Buttons --}}
        <form id="permissions-form" method="POST" action="{{ route('admin.roles.update', $selectedRole) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Box 1: Available Permissions Catalog --}}
                <div class="flex flex-col rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>Katalog Hak Akses Tersedia</span>
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600" id="available-counter">0</span>
                            </h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol <strong>[+]</strong> atau <strong>drag</strong> ke kotak kanan untuk mengaktifkan akses.</p>
                        </div>
                    </div>

                    {{-- Search Filter for Available Permissions --}}
                    <div class="mb-4">
                        <div class="relative">
                            <input type="text" 
                                   id="search-permissions" 
                                   placeholder="Cari izin akses (misal: create_instruments, view_...)" 
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                        </div>
                    </div>

                    {{-- Available List Container --}}
                    <div id="available-container" class="flex-1 space-y-4 max-h-[560px] overflow-y-auto pr-1">
                        @foreach($allPermissions as $groupName => $groupPerms)
                            <div class="permission-group rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5" data-group="{{ $groupName }}">
                                <h4 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-2.5 flex items-center justify-between">
                                    <span>{{ $groupName }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">{{ count($groupPerms) }} Izin</span>
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($groupPerms as $perm)
                                        @php
                                            $isAssigned = in_array($perm->id, $assignedPermissionIds);
                                        @endphp
                                        <div class="perm-chip tap-press group flex items-center gap-2 rounded-xl px-3 py-1.5 text-xs font-bold border transition-all duration-200 cursor-grab active:cursor-grabbing
                                            {{ $isAssigned ? 'opacity-40 pointer-events-none bg-slate-100 text-slate-400 border-slate-200' : 'bg-white text-slate-700 border-slate-200/90 shadow-2xs hover:border-brand-400 hover:text-brand-700' }}"
                                             id="perm-avail-{{ $perm->id }}"
                                             data-id="{{ $perm->id }}"
                                             data-name="{{ $perm->name }}"
                                             data-label="{{ $perm->label }}"
                                             data-group="{{ $perm->group }}"
                                             draggable="{{ $isAssigned ? 'false' : 'true' }}"
                                             ondragstart="handleDragStart(event)">
                                            <span class="font-mono text-[11px] text-brand-600">{{ $perm->name }}</span>
                                            <span class="text-slate-400 font-normal">|</span>
                                            <span class="text-[11px] text-slate-600">{{ $perm->label }}</span>
                                            @if(!$isAssigned)
                                                <button type="button" 
                                                        onclick="addPermission({{ $perm->id }}, '{{ $perm->name }}', '{{ addslashes($perm->label) }}', '{{ $perm->group }}')"
                                                        title="Tambah Izin"
                                                        class="ml-1 flex h-5 w-5 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition-colors hover:bg-brand-600 hover:text-white">
                                                    +
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Box 2: Assigned Permissions (Dropzone) --}}
                <div class="flex flex-col rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>Hak Akses Aktif Role {{ $selectedRole->name }}</span>
                                <span class="rounded-full bg-brand-100 px-2.5 py-0.5 text-[10px] font-extrabold text-brand-800" id="assigned-counter">{{ count($assignedPermissionIds) }}</span>
                            </h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Izin yang aktif pada role ini. Klik <strong>[×]</strong> untuk mencabut.</p>
                        </div>

                        {{-- Quick Presets --}}
                        <div class="flex items-center gap-1.5">
                            <button type="button" 
                                    onclick="applyViewOnlyPreset()"
                                    class="tap-press rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-700 hover:bg-slate-200 transition-colors"
                                    title="Hanya beri izin view (View-Only)">
                                Set View-Only
                            </button>
                        </div>
                    </div>

                    {{-- Dropzone Container --}}
                    <div id="dropzone" 
                         ondragover="handleDragOver(event)" 
                         ondragleave="handleDragLeave(event)" 
                         ondrop="handleDrop(event)"
                         class="flex-1 min-h-[380px] max-h-[560px] overflow-y-auto rounded-2xl border-2 border-dashed border-slate-200 p-4 transition-all duration-200 bg-slate-50/50">
                        
                        <div id="assigned-list" class="flex flex-wrap gap-2">
                            @forelse($allPermissions->flatten()->whereIn('id', $assignedPermissionIds) as $assignedPerm)
                                <div class="assigned-chip tap-press flex items-center gap-2 rounded-xl bg-white px-3 py-1.5 text-xs font-bold text-brand-950 border border-brand-300 shadow-2xs transition-all"
                                     id="assigned-chip-{{ $assignedPerm->id }}"
                                     data-id="{{ $assignedPerm->id }}"
                                     data-name="{{ $assignedPerm->name }}">
                                    <input type="hidden" name="permission_ids[]" value="{{ $assignedPerm->id }}">
                                    <span class="font-mono text-[11px] text-brand-600">{{ $assignedPerm->name }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span class="text-[11px] text-slate-700">{{ $assignedPerm->label }}</span>
                                    <button type="button" 
                                            onclick="removePermission({{ $assignedPerm->id }})" 
                                            class="ml-1 flex h-4 w-4 items-center justify-center rounded-md bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-colors"
                                            title="Cabut Izin">
                                        &times;
                                    </button>
                                </div>
                            @empty
                                <div id="empty-state" class="w-full py-16 text-center text-xs font-semibold text-slate-400">
                                    <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <p>Belum ada hak akses yang diberikan untuk role ini.</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Tarik (drag) atau klik tombol [+] di kotak sebelah kiri.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Action Footer --}}
                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" 
                                onclick="document.getElementById('reset-form').submit()"
                                class="tap-press inline-flex items-center gap-1.5 rounded-2xl bg-slate-100 hover:bg-rose-50 hover:text-rose-700 px-4 py-2 text-xs font-bold text-slate-600 border border-slate-200 transition-colors">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Reset ke Bawaan</span>
                        </button>

                        <button type="submit" 
                                class="tap-press inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-6 py-2.5 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 hover:bg-brand-700 transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Hak Akses Role</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Hidden Form for Reset --}}
        <form id="reset-form" method="POST" action="{{ route('admin.roles.resetDefault', $selectedRole) }}" class="hidden" onsubmit="return confirm('Kembalikan hak akses role ini ke pengaturan bawaan?')">
            @csrf
        </form>
    @endif
@endsection

@push('scripts')
<script>
    let draggedData = null;

    function handleDragStart(e) {
        const chip = e.target.closest('.perm-chip');
        if (!chip) return;
        draggedData = {
            id: chip.dataset.id,
            name: chip.dataset.name,
            label: chip.dataset.label,
            group: chip.dataset.group
        };
        e.dataTransfer.setData('text/plain', JSON.stringify(draggedData));
        chip.classList.add('opacity-50');
    }

    function handleDragOver(e) {
        e.preventDefault();
        const dropzone = document.getElementById('dropzone');
        if (dropzone) {
            dropzone.classList.add('border-brand-500', 'bg-brand-50/30');
        }
    }

    function handleDragLeave(e) {
        const dropzone = document.getElementById('dropzone');
        if (dropzone) {
            dropzone.classList.remove('border-brand-500', 'bg-brand-50/30');
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        const dropzone = document.getElementById('dropzone');
        if (dropzone) {
            dropzone.classList.remove('border-brand-500', 'bg-brand-50/30');
        }

        try {
            const raw = e.dataTransfer.getData('text/plain');
            const data = raw ? JSON.parse(raw) : draggedData;
            if (data && data.id) {
                addPermission(data.id, data.name, data.label, data.group);
            }
        } catch (err) {
            console.error('Drop error:', err);
        }
    }

    function addPermission(id, name, label, group) {
        // Prevent duplicate
        if (document.getElementById(`assigned-chip-${id}`)) {
            return;
        }

        const assignedList = document.getElementById('assigned-list');
        const emptyState = document.getElementById('empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        // Create new chip in assigned list
        const chipEl = document.createElement('div');
        chipEl.className = 'assigned-chip tap-press flex items-center gap-2 rounded-xl bg-white px-3 py-1.5 text-xs font-bold text-brand-950 border border-brand-300 shadow-2xs transition-all animate-slide-down';
        chipEl.id = `assigned-chip-${id}`;
        chipEl.dataset.id = id;
        chipEl.dataset.name = name;
        chipEl.innerHTML = `
            <input type="hidden" name="permission_ids[]" value="${id}">
            <span class="font-mono text-[11px] text-brand-600">${name}</span>
            <span class="text-slate-300">|</span>
            <span class="text-[11px] text-slate-700">${label}</span>
            <button type="button" onclick="removePermission(${id})" class="ml-1 flex h-4 w-4 items-center justify-center rounded-md bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-colors" title="Cabut Izin">&times;</button>
        `;

        assignedList.appendChild(chipEl);

        // Mark available chip as disabled
        const availChip = document.getElementById(`perm-avail-${id}`);
        if (availChip) {
            availChip.classList.add('opacity-40', 'pointer-events-none', 'bg-slate-100', 'text-slate-400', 'border-slate-200');
            availChip.classList.remove('bg-white', 'text-slate-700', 'border-slate-200/90', 'hover:border-brand-400');
            availChip.setAttribute('draggable', 'false');
            const btn = availChip.querySelector('button');
            if (btn) btn.remove();
        }

        updateCounters();
    }

    function removePermission(id) {
        const chip = document.getElementById(`assigned-chip-${id}`);
        if (chip) {
            chip.remove();
        }

        // Re-enable in available list
        const availChip = document.getElementById(`perm-avail-${id}`);
        if (availChip) {
            availChip.classList.remove('opacity-40', 'pointer-events-none', 'bg-slate-100', 'text-slate-400', 'border-slate-200');
            availChip.classList.add('bg-white', 'text-slate-700', 'border-slate-200/90', 'hover:border-brand-400');
            availChip.setAttribute('draggable', 'true');
            if (!availChip.querySelector('button')) {
                const name = availChip.dataset.name;
                const label = availChip.dataset.label;
                const group = availChip.dataset.group;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.title = 'Tambah Izin';
                btn.className = 'ml-1 flex h-5 w-5 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition-colors hover:bg-brand-600 hover:text-white';
                btn.innerHTML = '+';
                btn.onclick = () => addPermission(id, name, label, group);
                availChip.appendChild(btn);
            }
        }

        const assignedList = document.getElementById('assigned-list');
        if (assignedList && assignedList.children.length === 0) {
            assignedList.innerHTML = `
                <div id="empty-state" class="w-full py-16 text-center text-xs font-semibold text-slate-400">
                    <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <p>Belum ada hak akses yang diberikan untuk role ini.</p>
                    <p class="text-[11px] text-slate-400 mt-1">Tarik (drag) atau klik tombol [+] di kotak sebelah kiri.</p>
                </div>
            `;
        }

        updateCounters();
    }

    function updateCounters() {
        const assignedCount = document.querySelectorAll('.assigned-chip').length;
        const counterEl = document.getElementById('assigned-counter');
        if (counterEl) counterEl.textContent = assignedCount;
    }

    function applyViewOnlyPreset() {
        // Clear all non-view permissions
        document.querySelectorAll('.assigned-chip').forEach(chip => {
            const name = chip.dataset.name;
            if (!name.startsWith('view_')) {
                removePermission(chip.dataset.id);
            }
        });

        // Add all view permissions from available
        document.querySelectorAll('.perm-chip').forEach(chip => {
            const name = chip.dataset.name;
            if (name.startsWith('view_')) {
                addPermission(chip.dataset.id, name, chip.dataset.label, chip.dataset.group);
            }
        });
    }

    // Search filter in available list
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-permissions');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                document.querySelectorAll('.perm-chip').forEach(chip => {
                    const text = (chip.dataset.name + ' ' + chip.dataset.label).toLowerCase();
                    if (text.includes(term)) {
                        chip.style.display = '';
                    } else {
                        chip.style.display = 'none';
                    }
                });

                document.querySelectorAll('.permission-group').forEach(group => {
                    const visibleChips = group.querySelectorAll('.perm-chip:not([style*="display: none"])');
                    group.style.display = visibleChips.length > 0 ? '' : 'none';
                });
            });
        }
        updateCounters();
    });
</script>
@endpush
