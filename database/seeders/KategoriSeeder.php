<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = collect([
            'Kelas X',
            'Kelas XI',
            'Kelas XII'
        ]);

        $kategori->each( function ($item) {
            Kategori::create([
                'nama' => $item,
                'slug' => Str::slug($item)
            ]);
        });
    }
}
