<?php

namespace Database\Factories;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnggotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Anggota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nama = $this->faker->name();

        return [
            'nis' => $this->faker->ean8(),
            'nama' => $nama,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kelas_id' => $this->faker->randomElement([1, 2, 3]),
            'slug' => Str::slug($nama)
        ];
    }
}
