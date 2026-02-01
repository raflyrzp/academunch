<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_produk',
        'harga',
        'total_harga',
        'kuantitas',
        'invoice',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'integer',
        'total_harga' => 'integer',
        'kuantitas' => 'integer',
    ];

    /**
     * Status constants
     */
    public const STATUS_DIPESAN = 'dipesan';
    public const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    public const STATUS_DITOLAK = 'ditolak';
    public const STATUS_BATAL = 'batal';

    /**
     * Get the user that owns the transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the produk that owns the transaksi.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk')->withTrashed();
    }

    /**
     * Scope untuk transaksi yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_DIPESAN);
    }

    /**
     * Scope untuk transaksi yang dikonfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_DIKONFIRMASI);
    }

    /**
     * Scope untuk transaksi aktif (dipesan atau dikonfirmasi)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_DIPESAN, self::STATUS_DIKONFIRMASI]);
    }

    /**
     * Cek apakah transaksi sudah dikonfirmasi
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_DIKONFIRMASI;
    }

    /**
     * Cek apakah transaksi masih pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_DIPESAN;
    }
}
