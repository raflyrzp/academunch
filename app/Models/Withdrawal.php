<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rekening',
        'nominal',
        'kode_unik',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nominal' => 'integer',
    ];

    /**
     * Status constants
     */
    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    public const STATUS_DITOLAK = 'ditolak';

    /**
     * Get the wallet that owns the withdrawal.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'rekening', 'rekening');
    }

    /**
     * Scope untuk withdrawal yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    /**
     * Scope untuk withdrawal yang dikonfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_DIKONFIRMASI);
    }

    /**
     * Cek apakah masih pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    /**
     * Cek apakah sudah dikonfirmasi
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_DIKONFIRMASI;
    }

    /**
     * Format nominal sebagai rupiah
     */
    public function getFormattedNominalAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
