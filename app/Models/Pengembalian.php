<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $guarded = [];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class)->withPivot(['status']);
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function ($model) {
            $model->kode = str_pad(Pengembalian::max('id') + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
