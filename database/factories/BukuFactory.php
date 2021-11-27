<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BukuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Buku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $judul = $this->faker->colorName();

        return [
            'kode' => $this->faker->unique()->isbn10(),
            'judul' => $judul,
            'kategori_id' => $this->faker->randomElement([1, 2, 3]),
            'pengarang' => $this->faker->name(),
            'penerbit' => $this->faker->company(),
            'tahun' => $this->faker->year($max = 'now'),
            'stok' => $this->faker->numberBetween($min = 100, $max = 500),
            'slug' => Str::slug($judul)
        ];
    }
}
