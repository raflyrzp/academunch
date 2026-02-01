<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rekening',
        'id_user',
        'saldo',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'saldo' => 'integer',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get all topups for the wallet.
     */
    public function topups(): HasMany
    {
        return $this->hasMany(TopUp::class, 'rekening', 'rekening');
    }

    /**
     * Get all withdrawals for the wallet.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'rekening', 'rekening');
    }

    /**
     * Cek apakah wallet aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Cek apakah saldo mencukupi
     */
    public function hasSufficientBalance(int $amount): bool
    {
        return $this->saldo >= $amount;
    }

    /**
     * Format saldo sebagai rupiah
     */
    public function getFormattedSaldoAttribute(): string
    {
        return 'Rp ' . number_format($this->saldo, 0, ',', '.');
    }
}
