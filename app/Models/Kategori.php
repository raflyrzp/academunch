<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get all produks for the kategori.
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }

    /**
     * Get jumlah produk dalam kategori ini.
     */
    public function getProductCountAttribute(): int
    {
        return $this->produks()->count();
    }
}
