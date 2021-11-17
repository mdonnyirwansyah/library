<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pengembalian';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class)->withPivot(['status']);
    }
}
