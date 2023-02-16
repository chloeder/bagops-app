<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = ['Data Kumtua', 'Data Buronan', 'Data BABIN'];

        foreach ($kategori as $c) {
            Category::create([
                'nama' => $c,
            ]);
        }
    }
}
