<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'image_path',
        'order',
    ];

    public static array $positions = [
        'Pengurus Harian' => [
            'Ketua' => 'Ketua',
            'Wakil' => 'Wakil',
            'Sekretaris 1' => 'Sekretaris 1',
            'Sekretaris 2' => 'Sekretaris 2',
            'Bendahara 1' => 'Bendahara 1',
            'Bendahara 2' => 'Bendahara 2',
        ],
        'Divisi Humas' => [
            'Humas (Koordinator)' => 'Koordinator',
            'Anggota Humas' => 'Anggota',
        ],
        'Divisi Alat Musik' => [
            'Alat Musik (Koordinator)' => 'Koordinator',
            'Anggota Alat Musik' => 'Anggota',
        ],
        'Divisi Vocal' => [
            'Vocal (Koordinator)' => 'Koordinator',
            'Anggota Vocal' => 'Anggota',
        ],
        'Divisi Kegiatan' => [
            'Kegiatan (Koordinator)' => 'Koordinator',
            'Anggota Kegiatan' => 'Anggota',
        ],
        'Divisi PDD' => [
            'PDD (Koordinator)' => 'Koordinator',
            'Anggota PDD' => 'Anggota',
        ],
        'Divisi Perkap' => [
            'Perkap (Koordinator)' => 'Koordinator',
            'Anggota Perkap' => 'Anggota',
        ],
        'Divisi Wirausaha' => [
            'Wirausaha (Koordinator)' => 'Koordinator',
            'Anggota Wirausaha' => 'Anggota',
        ],
    ];

    public static function getPositionWeights(): array
    {
        return [
            'Ketua' => 10,
            'Wakil' => 20,
            'Sekretaris 1' => 30,
            'Sekretaris 2' => 31,
            'Bendahara 1' => 40,
            'Bendahara 2' => 41,
            'Humas (Koordinator)' => 50,
            'Anggota Humas' => 51,
            'Alat Musik (Koordinator)' => 60,
            'Anggota Alat Musik' => 61,
            'Vocal (Koordinator)' => 70,
            'Anggota Vocal' => 71,
            'Kegiatan (Koordinator)' => 80,
            'Anggota Kegiatan' => 81,
            'PDD (Koordinator)' => 90,
            'Anggota PDD' => 91,
            'Perkap (Koordinator)' => 100,
            'Anggota Perkap' => 101,
            'Wirausaha (Koordinator)' => 110,
            'Anggota Wirausaha' => 111,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MemberStructure $member) {
            $weights = static::getPositionWeights();
            if (isset($weights[$member->position])) {
                $member->order = $weights[$member->position];
            }
        });
    }

    public function getDivisionGroupAttribute(): string
    {
        if (in_array($this->position, ['Ketua', 'Wakil', 'Sekretaris 1', 'Sekretaris 2', 'Bendahara 1', 'Bendahara 2'])) {
            return 'Pengurus Harian';
        }
        if (str_contains($this->position, 'Humas')) {
            return 'Humas';
        }
        if (str_contains($this->position, 'Alat Musik')) {
            return 'Alat Musik';
        }
        if (str_contains($this->position, 'Vocal')) {
            return 'Vocal';
        }
        if (str_contains($this->position, 'Kegiatan')) {
            return 'Kegiatan';
        }
        if (str_contains($this->position, 'PDD')) {
            return 'PDD';
        }
        if (str_contains($this->position, 'Perkap')) {
            return 'Perkap';
        }
        if (str_contains($this->position, 'Wirausaha')) {
            return 'Wirausaha';
        }

        return 'Divisi';
    }

    public function getDisplayPositionAttribute(): string
    {
        if (str_contains($this->position, '(Koordinator)')) {
            return 'Koordinator';
        }
        if (str_contains($this->position, 'Anggota')) {
            return 'Anggota';
        }
        return $this->position;
    }
}
