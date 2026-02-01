<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'foto',
        'desc',
        'id_kategori',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the kategori that owns the produk.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Get all transaksis for the produk.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_produk')->withTrashed();
    }

    /**
     * Get all keranjangs for the produk.
     */
    public function keranjangs(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'id_produk');
    }

    /**
     * Get the full URL for the product image.
     */
    public function getFotoUrlAttribute(): string
    {
        return asset('storage/produk/' . $this->foto);
    }

    /**
     * Scope untuk produk yang tersedia (stok > 0)
     */
    public function scopeAvailable($query)
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Cek apakah produk tersedia
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
