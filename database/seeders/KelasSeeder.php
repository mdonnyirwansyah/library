<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = collect([
            'X MIPA 1',
            'XI MIPA 1',
            'XII MIPA 1',
            'XII MIPA 2'
        ]);

        $kelas->each( function ($item) {
            Kelas::create([
                'kelas' => $item,
                'slug' => Str::slug($item)
            ]);
        });
    }
}
