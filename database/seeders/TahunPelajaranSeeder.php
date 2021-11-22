<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TahunPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahunPelajaran = collect([
            '2019/2020',
            '2020/2021',
            '2021/2022'
        ]);

        $tahunPelajaran->each( function ($item) {
            TahunPelajaran::create([
                'tahun' => $item,
                'slug' => Str::slug($item)
            ]);
        });
    }
}
