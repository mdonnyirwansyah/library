<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\Kelas;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class AnggotaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    public function __construct()
    {
        $this->kelas = Kelas::select('id', 'kelas')->get();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kelas = $this->kelas->where('kelas', $row['kelas'])->first();
        return new Anggota([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'kelas_id' => $kelas->id ?? NULL,
            'slug' => Str::slug($row['nama'])
        ]);
    }

    public function onError(Throwable $e)
    {

    }
}
