<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'location',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery): void {
            if (empty($gallery->slug)) {
                $baseSlug = Str::slug($gallery->title);
                $slug = $baseSlug;
                $counter = 1;

                while (static::where('slug', $slug)->where('id', '!=', $gallery->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$counter++;
                }

                $gallery->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<GalleryPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('order')->orderBy('id');
    }
}
