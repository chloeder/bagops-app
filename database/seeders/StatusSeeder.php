<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Ditunda', 'Diterima', 'Terlambat'];

        foreach ($status as $s) {
            Status::create([
                'nama' => $s,
            ]);
        }
    }
}
