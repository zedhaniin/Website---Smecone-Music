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
        'Pengurus Inti' => [
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
            return 'Pengurus Inti';
        }
        if (str_contains($this->position, 'Humas')) {
            return 'Divisi Humas';
        }
        if (str_contains($this->position, 'Alat Musik')) {
            return 'Divisi Alat Musik';
        }
        if (str_contains($this->position, 'Vocal')) {
            return 'Divisi Vocal';
        }
        if (str_contains($this->position, 'Kegiatan')) {
            return 'Divisi Kegiatan';
        }
        if (str_contains($this->position, 'PDD')) {
            return 'Divisi PDD';
        }
        if (str_contains($this->position, 'Perkap')) {
            return 'Divisi Perkap';
        }
        if (str_contains($this->position, 'Wirausaha')) {
            return 'Divisi Wirausaha';
        }

        return 'Divisi';
    }

    public static function getDivisionDefinitions(): array
    {
        return [
            'pengurus-inti' => [
                'slug' => 'pengurus-inti',
                'name' => 'Pengurus Inti',
                'category' => 'Pimpinan & Pengurus Inti',
                'description' => 'Pemegang amanah tertinggi dalam pengambilan kebijakan strategis dan penentu arah gerak organisasi Smecone Music.',
                'db_group' => 'Pengurus Inti',
            ],
            'humas' => [
                'slug' => 'humas',
                'name' => 'Divisi Humas',
                'category' => 'Pengurus Harian',
                'description' => 'Menjalin komunikasi, membangun relasi publik, serta menjaga citra positif organisasi Smecone Music.',
                'db_group' => 'Divisi Humas',
            ],
            'alat-musik' => [
                'slug' => 'alat-musik',
                'name' => 'Divisi Alat Musik',
                'category' => 'Pengurus Harian',
                'description' => 'Mengelola inventaris, pemeliharaan, dan optimalisasi seluruh peralatan serta fasilitas musik.',
                'db_group' => 'Divisi Alat Musik',
            ],
            'vocal' => [
                'slug' => 'vocal',
                'name' => 'Divisi Vocal',
                'category' => 'Pengurus Harian',
                'description' => 'Mengembangkan bakat vokal, tata aransemen nada, dan keharmonisan paduan suara.',
                'db_group' => 'Divisi Vocal',
            ],
            'kegiatan' => [
                'slug' => 'kegiatan',
                'name' => 'Divisi Kegiatan',
                'category' => 'Pengurus Harian',
                'description' => 'Merencanakan dan mengeksekusi berbagai program kerja, event, concert, serta pertunjukan.',
                'db_group' => 'Divisi Kegiatan',
            ],
            'pdd' => [
                'slug' => 'pdd',
                'name' => 'Divisi PDD',
                'category' => 'Pengurus Harian',
                'description' => 'Publikasi, Dekorasi, & Dokumentasi. Mengabadikan setiap momen dan merancang ide visual.',
                'db_group' => 'Divisi PDD',
            ],
            'perkap' => [
                'slug' => 'perkap',
                'name' => 'Divisi Perkap',
                'category' => 'Pengurus Harian',
                'description' => 'Menyiapkan perlengkapan teknis, logistik, dan stage setup kelancaran penampilan.',
                'db_group' => 'Divisi Perkap',
            ],
            'wirausaha' => [
                'slug' => 'wirausaha',
                'name' => 'Divisi Wirausaha',
                'category' => 'Pengurus Harian',
                'description' => 'Mengelola usaha kreatif organisasi dan ketersediaan dana mandiri operasional.',
                'db_group' => 'Divisi Wirausaha',
            ],
        ];
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
