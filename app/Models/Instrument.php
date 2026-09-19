<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'quantity',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    /**
     * @return HasMany<Borrowing, $this>
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get the number of currently active (approved, not returned) borrowings.
     */
    public function activeBorrowingsCount(): int
    {
        return $this->borrowings()
            ->where('status', 'approved')
            ->count();
    }

    /**
     * Check if the instrument has available stock for borrowing.
     */
    public function hasAvailableStock(): bool
    {
        return $this->is_available && ($this->quantity - $this->activeBorrowingsCount()) > 0;
    }
}
