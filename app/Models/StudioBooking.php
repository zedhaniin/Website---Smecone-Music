<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudioBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'purpose',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if this booking overlaps with another approved booking.
     */
    public function overlapsWithApproved(): bool
    {
        return static::where('id', '!=', $this->id ?? 0)
            ->where('status', 'approved')
            ->where('start_time', '<', $this->end_time)
            ->where('end_time', '>', $this->start_time)
            ->exists();
    }
}
