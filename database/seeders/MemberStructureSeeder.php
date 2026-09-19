<?php

namespace Database\Seeders;

use App\Models\MemberStructure;
use Illuminate\Database\Seeder;

class MemberStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MemberStructure::truncate();

        $members = [
            ['name' => 'Sheren Olivia', 'position' => 'Ketua'],
            ['name' => 'Zed Haniin', 'position' => 'Wakil'],
            ['name' => 'Tiara', 'position' => 'Sekretaris 1'],
            ['name' => 'Najwa', 'position' => 'Sekretaris 2'],
            ['name' => 'Gandes', 'position' => 'Bendahara 1'],
            ['name' => 'Imanuella Gizel', 'position' => 'Bendahara 2'],
            ['name' => 'Chelsa', 'position' => 'Humas (Koordinator)'],
            ['name' => 'Sabilla Kinan', 'position' => 'Anggota Humas'],
            ['name' => 'Sekar wanda', 'position' => 'Anggota Humas'],
            ['name' => 'Hilmi', 'position' => 'Alat Musik (Koordinator)'],
            ['name' => 'Fahri', 'position' => 'Anggota Alat Musik'],
            ['name' => 'Galang', 'position' => 'Anggota Alat Musik'],
            ['name' => 'Aznah', 'position' => 'Vocal (Koordinator)'],
            ['name' => 'Yusuf', 'position' => 'Anggota Vocal'],
            ['name' => 'Florisa', 'position' => 'Anggota Vocal'],
            ['name' => 'Nadissa', 'position' => 'Kegiatan (Koordinator)'],
            ['name' => 'Aziz', 'position' => 'Anggota Kegiatan'],
            ['name' => 'Dara', 'position' => 'Anggota Kegiatan'],
            ['name' => 'Shelly', 'position' => 'PDD (Koordinator)'],
            ['name' => 'Fidella', 'position' => 'Anggota PDD'],
            ['name' => 'Fadilla', 'position' => 'Anggota PDD'],
            ['name' => 'Lail', 'position' => 'Perkap (Koordinator)'],
            ['name' => 'Inez', 'position' => 'Anggota Perkap'],
            ['name' => 'Hosea', 'position' => 'Anggota Perkap'],
            ['name' => 'Virzza', 'position' => 'Wirausaha (Koordinator)'],
            ['name' => 'Rafeifa', 'position' => 'Anggota Wirausaha'],
            ['name' => 'Benita', 'position' => 'Anggota Wirausaha'],
        ];

        foreach ($members as $member) {
            MemberStructure::create($member);
        }
    }
}
