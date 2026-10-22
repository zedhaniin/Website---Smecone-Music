<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'cover_image_path',
        'order',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(MemberStructure::class, 'division_id')->orderBy('order')->orderBy('id');
    }

    protected static function booted(): void
    {
        static::creating(function (Division $division) {
            if (empty($division->slug)) {
                $division->slug = Str::slug($division->name);
            }
        });
    }
}
