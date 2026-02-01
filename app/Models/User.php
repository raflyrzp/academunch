<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Cek apakah user adalah siswa
     */
    public function isSiswa(): bool
    {
        return $this->hasRole('siswa');
    }

    /**
     * Cek apakah user adalah bank
     */
    public function isBank(): bool
    {
        return $this->hasRole('bank');
    }

    /**
     * Cek apakah user adalah kantin
     */
    public function isKantin(): bool
    {
        return $this->hasRole('kantin');
    }

    /**
     * Get the wallet for the user.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'id_user');
    }

    /**
     * Get all wallets for the user (legacy support).
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class, 'id_user');
    }

    /**
     * Get all transaksis for the user.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }

    /**
     * Get all keranjangs for the user.
     */
    public function keranjangs(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }
}
