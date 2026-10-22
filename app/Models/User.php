<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name', 'email', 'phone', 'class_name', 'instrument_division', 'management_division',
    'password', 'role', 'is_approved', 'email_verified_at', 'otp_code', 'otp_expires_at'
])]
#[Hidden(['password', 'remember_token', 'otp_code'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [
            'admin', 'ketua', 'wakil', 'sekretaris', 'bendahara',
            'pengurus_perkap', 'pengurus_pdd', 'pengurus_alat_musik', 'pengurus',
        ]);
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['admin', 'ketua', 'wakil']);
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string ...$roles): bool
    {
        if (in_array('admin', $roles) && $this->isAdmin()) {
            return true;
        }

        if (in_array('super_admin', $roles) && $this->isSuperAdmin()) {
            return true;
        }

        return in_array($this->role, $roles);
    }

    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role', 'slug');
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $role = $this->roleModel;
        if (! $role) {
            return false;
        }

        return $role->permissions->contains('name', $permission);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'ketua' => 'Ketua (Super Admin)',
            'wakil' => 'Wakil Ketua (Super Admin)',
            'sekretaris' => 'Sekretaris (Pengurus Inti)',
            'bendahara' => 'Bendahara (Pengurus Inti)',
            'pengurus_perkap' => 'Pengurus (Perkap)',
            'pengurus_pdd' => 'Pengurus (PDD)',
            'pengurus_alat_musik' => 'Pengurus (Alat Musik)',
            'pengurus' => 'Pengurus (Divisi Lain)',
            'admin' => 'Admin (Super Admin)',
            default => 'Anggota',
        };
    }

    /**
     * @return HasMany<Borrowing, $this>
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * @return HasMany<StudioBooking, $this>
     */
    public function studioBookings(): HasMany
    {
        return $this->hasMany(StudioBooking::class);
    }
}
