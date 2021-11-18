<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'peminjaman';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class)->withPivot(['jumlah']);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
