<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periode = collect([
            '2019/2020',
            '2020/2021',
            '2021/2022'
        ]);

        $periode->each( function ($item) {
            Periode::create([
                'nama' => $item,
                'slug' => Str::slug($item)
            ]);
        });
    }
}
