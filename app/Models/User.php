<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone_number',
        'role',
        'status',
        'admin_notes',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is suspended
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Suspend user
     */
    public function suspend(string $reason = null): void
    {
        $this->update([
            'status' => 'suspended',
            'admin_notes' => $reason ? "Suspended: {$reason}" : 'Suspended by admin'
        ]);
    }

    /**
     * Activate user
     */
    public function activate(): void
    {
        $this->update([
            'status' => 'active',
            'admin_notes' => 'Activated by admin'
        ]);
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get user's bids
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Get auctions managed by staff
     */
    public function managedAuctions()
    {
        return $this->hasMany(Auction::class, 'staff_id');
    }

    /**
     * Get auctions won by user
     */
    public function wonAuctions()
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }
}
