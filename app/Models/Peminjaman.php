<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function Tahun_pelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class)->withPivot(['jumlah']);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating( function ($model) {
            $model->kode = str_pad(Peminjaman::max('id') + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
