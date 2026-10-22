<?php

use App\Models\MemberStructure;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('Pengurus Harian');
            $table->text('description')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::table('member_structures', function (Blueprint $table) {
            $table->foreignId('division_id')->nullable()->after('id')->constrained('divisions')->nullOnDelete();
        });

        // Seed default divisions
        $divisionDefs = [
            [
                'name' => 'Pengurus Inti',
                'slug' => 'pengurus-inti',
                'category' => 'Pimpinan & Pengurus Inti',
                'description' => 'Pemegang amanah tertinggi dalam pengambilan kebijakan strategis dan penentu arah gerak organisasi Smecone Music.',
                'order' => 1,
            ],
            [
                'name' => 'Divisi Humas',
                'slug' => 'humas',
                'category' => 'Pengurus Harian',
                'description' => 'Menjalin komunikasi, membangun relasi publik, serta menjaga citra positif organisasi Smecone Music.',
                'order' => 2,
            ],
            [
                'name' => 'Divisi Alat Musik',
                'slug' => 'alat-musik',
                'category' => 'Pengurus Harian',
                'description' => 'Mengelola inventaris, pemeliharaan, dan optimalisasi seluruh peralatan serta fasilitas musik.',
                'order' => 3,
            ],
            [
                'name' => 'Divisi Vocal',
                'slug' => 'vocal',
                'category' => 'Pengurus Harian',
                'description' => 'Mengembangkan bakat vokal, tata aransemen nada, dan keharmonisan paduan suara.',
                'order' => 4,
            ],
            [
                'name' => 'Divisi Kegiatan',
                'slug' => 'kegiatan',
                'category' => 'Pengurus Harian',
                'description' => 'Merencanakan dan mengeksekusi berbagai program kerja, event, concert, serta pertunjukan.',
                'order' => 5,
            ],
            [
                'name' => 'Divisi PDD',
                'slug' => 'pdd',
                'category' => 'Pengurus Harian',
                'description' => 'Publikasi, Dekorasi, & Dokumentasi. Mengabadikan setiap momen dan merancang ide visual.',
                'order' => 6,
            ],
            [
                'name' => 'Divisi Perkap',
                'slug' => 'perkap',
                'category' => 'Pengurus Harian',
                'description' => 'Menyiapkan perlengkapan teknis, logistik, dan stage setup kelancaran penampilan.',
                'order' => 7,
            ],
            [
                'name' => 'Divisi Wirausaha',
                'slug' => 'wirausaha',
                'category' => 'Pengurus Harian',
                'description' => 'Mengelola usaha kreatif organisasi dan ketersediaan dana mandiri operasional.',
                'order' => 8,
            ],
        ];

        foreach ($divisionDefs as $def) {
            $divisionId = DB::table('divisions')->insertGetId(array_merge($def, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // Link existing member_structures to this division based on position
            $matchPattern = match ($def['slug']) {
                'pengurus-inti' => ['Ketua', 'Wakil', 'Sekretaris 1', 'Sekretaris 2', 'Bendahara 1', 'Bendahara 2'],
                'humas' => '%Humas%',
                'alat-musik' => '%Alat Musik%',
                'vocal' => '%Vocal%',
                'kegiatan' => '%Kegiatan%',
                'pdd' => '%PDD%',
                'perkap' => '%Perkap%',
                'wirausaha' => '%Wirausaha%',
                default => null,
            };

            if (is_array($matchPattern)) {
                DB::table('member_structures')->whereIn('position', $matchPattern)->update(['division_id' => $divisionId]);
            } elseif (is_string($matchPattern)) {
                DB::table('member_structures')->where('position', 'like', $matchPattern)->update(['division_id' => $divisionId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_structures', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropColumn('division_id');
        });

        Schema::dropIfExists('divisions');
    }
};
