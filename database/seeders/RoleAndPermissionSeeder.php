<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Roles
        $rolesData = [
            [
                'name' => 'Ketua',
                'slug' => 'ketua',
                'group' => 'Pengurus Inti',
                'badge_color' => 'amber',
                'description' => 'Ketua Umum Smecone Music. Memiliki hak akses penuh ke seluruh fitur dan pengaturan hak akses role.',
            ],
            [
                'name' => 'Wakil Ketua',
                'slug' => 'wakil',
                'group' => 'Pengurus Inti',
                'badge_color' => 'amber',
                'description' => 'Wakil Ketua Smecone Music. Memiliki hak akses penuh ke seluruh fitur dan pengaturan hak akses role.',
            ],
            [
                'name' => 'Sekretaris',
                'slug' => 'sekretaris',
                'group' => 'Pengurus Inti',
                'badge_color' => 'indigo',
                'description' => 'Pengurus Inti. Dapat mengelola akun user, struktur kepengurusan, dan persetujuan peminjaman/booking.',
            ],
            [
                'name' => 'Bendahara',
                'slug' => 'bendahara',
                'group' => 'Pengurus Inti',
                'badge_color' => 'indigo',
                'description' => 'Pengurus Inti. Dapat mengelola akun user, struktur kepengurusan, dan persetujuan peminjaman/booking.',
            ],
            [
                'name' => 'Pengurus (Perkap)',
                'slug' => 'pengurus_perkap',
                'group' => 'Pengurus Divisi',
                'badge_color' => 'blue',
                'description' => 'Divisi Perlengkapan. Dapat menambah/mengedit inventaris alat musik & menyetujui peminjaman alat serta booking studio.',
            ],
            [
                'name' => 'Pengurus (PDD)',
                'slug' => 'pengurus_pdd',
                'group' => 'Pengurus Divisi',
                'badge_color' => 'purple',
                'description' => 'Divisi Publikasi, Desain & Dokumentasi. Dapat mengelola kepengurusan, galeri foto, dan showcase prestasi.',
            ],
            [
                'name' => 'Pengurus (Alat Musik)',
                'slug' => 'pengurus_alat_musik',
                'group' => 'Pengurus Divisi',
                'badge_color' => 'emerald',
                'description' => 'Divisi Alat Musik. Dapat mengelola dan memelihara data inventaris alat musik.',
            ],
            [
                'name' => 'Pengurus (Divisi Lain)',
                'slug' => 'pengurus',
                'group' => 'Pengurus Divisi',
                'badge_color' => 'slate',
                'description' => 'Pengurus Divisi Lainnya (Humas, Vocal, Kegiatan, Wirausaha). Memiliki akses melihat seluruh data di panel admin (View-Only).',
            ],
            [
                'name' => 'Anggota (User)',
                'slug' => 'user',
                'group' => 'Anggota',
                'badge_color' => 'slate',
                'description' => 'Anggota Biasa Smecone Music. Mengakses panel anggota untuk peminjaman alat dan booking studio.',
            ],
        ];

        $roles = [];
        foreach ($rolesData as $roleInfo) {
            $roles[$roleInfo['slug']] = Role::updateOrCreate(
                ['slug' => $roleInfo['slug']],
                $roleInfo
            );
        }

        // 2. Permissions Definition
        $permissionsData = [
            // Manajemen Akun User
            ['name' => 'view_users', 'label' => 'Lihat Daftar User', 'group' => 'Akun User', 'description' => 'Melihat daftar pengguna terdaftar'],
            ['name' => 'approve_users', 'label' => 'Setujui / Nonaktifkan User', 'group' => 'Akun User', 'description' => 'Menyetujui pendaftaran atau menonaktifkan akun'],
            ['name' => 'edit_users', 'label' => 'Ubah Role User', 'group' => 'Akun User', 'description' => 'Mengubah hak akses/role pengguna'],
            ['name' => 'delete_users', 'label' => 'Hapus User', 'group' => 'Akun User', 'description' => 'Menghapus akun pengguna dari sistem'],

            // Struktur Pengurus & Divisi
            ['name' => 'view_members', 'label' => 'Lihat Struktur Pengurus', 'group' => 'Kepengurusan', 'description' => 'Melihat bagan dan daftar anggota pengurus'],
            ['name' => 'create_members', 'label' => 'Tambah Anggota Pengurus', 'group' => 'Kepengurusan', 'description' => 'Menambahkan data anggota pengurus baru'],
            ['name' => 'edit_members', 'label' => 'Edit Anggota & Divisi', 'group' => 'Kepengurusan', 'description' => 'Mengubah foto, deskripsi divisi, dan data pengurus'],
            ['name' => 'delete_members', 'label' => 'Hapus Anggota Pengurus', 'group' => 'Kepengurusan', 'description' => 'Menghapus anggota dari struktur kepengurusan'],

            // Inventaris Alat Musik
            ['name' => 'view_instruments', 'label' => 'Lihat Inventaris Alat', 'group' => 'Inventaris Alat', 'description' => 'Melihat katalog dan daftar inventaris alat musik'],
            ['name' => 'create_instruments', 'label' => 'Tambah Alat Musik', 'group' => 'Inventaris Alat', 'description' => 'Menambahkan alat musik baru ke inventaris'],
            ['name' => 'edit_instruments', 'label' => 'Edit Alat Musik', 'group' => 'Inventaris Alat', 'description' => 'Mengubah info, jumlah, atau foto alat musik'],
            ['name' => 'delete_instruments', 'label' => 'Hapus Alat Musik', 'group' => 'Inventaris Alat', 'description' => 'Menghapus alat musik dari inventaris'],

            // Peminjaman Alat
            ['name' => 'view_borrowings', 'label' => 'Lihat Peminjaman Alat', 'group' => 'Peminjaman Alat', 'description' => 'Melihat daftar permohonan peminjaman alat'],
            ['name' => 'approve_borrowings', 'label' => 'Approval Peminjaman Alat', 'group' => 'Peminjaman Alat', 'description' => 'Menyetujui, menolak, atau menandai alat telah dikembalikan'],

            // Booking Studio
            ['name' => 'view_bookings', 'label' => 'Lihat Booking Studio', 'group' => 'Booking Studio', 'description' => 'Melihat jadwal dan pengajuan booking studio STM'],
            ['name' => 'approve_bookings', 'label' => 'Approval Booking Studio', 'group' => 'Booking Studio', 'description' => 'Menyetujui atau menolak permohonan booking studio'],

            // Galeri Foto
            ['name' => 'view_galleries', 'label' => 'Lihat Galeri Foto', 'group' => 'Galeri Foto', 'description' => 'Melihat album dan foto dokumentasi kegiatan'],
            ['name' => 'create_galleries', 'label' => 'Tambah Album Galeri', 'group' => 'Galeri Foto', 'description' => 'Membuat event galeri baru & upload foto'],
            ['name' => 'edit_galleries', 'label' => 'Edit Album & Foto Galeri', 'group' => 'Galeri Foto', 'description' => 'Mengubah informasi galeri dan menambah/menghapus foto'],
            ['name' => 'delete_galleries', 'label' => 'Hapus Album Galeri', 'group' => 'Galeri Foto', 'description' => 'Menghapus album kegiatan galeri'],

            // Showcase Prestasi
            ['name' => 'view_showcases', 'label' => 'Lihat Showcase Prestasi', 'group' => 'Showcase Prestasi', 'description' => 'Melihat daftar prestasi dan penghargaan'],
            ['name' => 'create_showcases', 'label' => 'Tambah Prestasi', 'group' => 'Showcase Prestasi', 'description' => 'Menambahkan portofolio atau prestasi baru'],
            ['name' => 'delete_showcases', 'label' => 'Hapus Prestasi', 'group' => 'Showcase Prestasi', 'description' => 'Menghapus data prestasi'],

            // Manajemen Role
            ['name' => 'manage_roles', 'label' => 'Kelola Hak Akses Role', 'group' => 'Manajemen Role', 'description' => 'Mengatur dan mengubah hak akses setiap role pengurus'],
        ];

        $permissions = [];
        foreach ($permissionsData as $permInfo) {
            $permissions[$permInfo['name']] = Permission::updateOrCreate(
                ['name' => $permInfo['name']],
                $permInfo
            );
        }

        // Helper to get permission IDs by names
        $getIds = function (array $names) use ($permissions) {
            return collect($names)
                ->map(fn ($name) => $permissions[$name]->id ?? null)
                ->filter()
                ->values()
                ->all();
        };

        // All View Permissions
        $allViews = [
            'view_users', 'view_members', 'view_instruments',
            'view_borrowings', 'view_bookings', 'view_galleries', 'view_showcases',
        ];

        // 3. Assign Default Permissions to Roles

        // Ketua & Wakil: ALL permissions
        $allPermissionIds = collect($permissions)->pluck('id')->all();
        $roles['ketua']->permissions()->sync($allPermissionIds);
        $roles['wakil']->permissions()->sync($allPermissionIds);

        // Sekretaris & Bendahara
        $sekrePermissions = array_merge($allViews, [
            'approve_users', 'edit_users',
            'create_members', 'edit_members', 'delete_members',
            'approve_borrowings', 'approve_bookings',
        ]);
        $roles['sekretaris']->permissions()->sync($getIds($sekrePermissions));
        $roles['bendahara']->permissions()->sync($getIds($sekrePermissions));

        // Pengurus Perkap
        $perkapPermissions = array_merge($allViews, [
            'create_instruments', 'edit_instruments', 'delete_instruments',
            'approve_borrowings', 'approve_bookings',
        ]);
        $roles['pengurus_perkap']->permissions()->sync($getIds($perkapPermissions));

        // Pengurus PDD
        $pddPermissions = array_merge($allViews, [
            'create_members', 'edit_members', 'delete_members',
            'create_galleries', 'edit_galleries', 'delete_galleries',
            'create_showcases', 'delete_showcases',
        ]);
        $roles['pengurus_pdd']->permissions()->sync($getIds($pddPermissions));

        // Pengurus Alat Musik
        $alatPermissions = array_merge($allViews, [
            'create_instruments', 'edit_instruments', 'delete_instruments',
        ]);
        $roles['pengurus_alat_musik']->permissions()->sync($getIds($alatPermissions));

        // Pengurus (Divisi Lain: Humas, Vocal, Kegiatan, Wirausaha) -> View-Only
        $roles['pengurus']->permissions()->sync($getIds($allViews));

        // Anggota / User -> Empty admin permissions
        $roles['user']->permissions()->sync([]);
    }
}
