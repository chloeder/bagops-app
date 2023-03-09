<?php

namespace Database\Seeders;

use App\Models\SatuanKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satker = ['Polres Minahasa', 'Polsek Tondano', 'Polsek Remboken', 'Polsek Eris', 'Polsek Kombi', 'Polsek Kakas', 'Polsek Kawangkoan', 'Polsek Langowan', 'Polsek Langowan Barat', 'Polsek Lembean Timur', 'Polsek Toulimambot', 'Polsek Tompaso'];

        foreach ($satker as $s) {
            SatuanKerja::create([
                'nama' => $s,
            ]);
        }
    }
}
