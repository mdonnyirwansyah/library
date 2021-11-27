<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class BukuImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    public function __construct()
    {
        $this->kategori = Kategori::select('id', 'kategori')->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kategori = $this->kategori->where('kategori', $row['kategori'])->first();
        return new Buku([
            'kode' => $row['kode'],
            'judul' => $row['judul'],
            'kategori_id' => $kategori->id ?? NULL,
            'pengarang' => $row['pengarang'],
            'penerbit' => $row['penerbit'],
            'tahun' => $row['tahun'],
            'stok' => $row['stok'],
            'slug' => Str::slug($row['judul'])
        ]);
    }

    public function onError(Throwable $e)
    {

    }
}
