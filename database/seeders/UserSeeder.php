<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'User',
                'name' => 'User',
                'email' => 'stewardyohanes29@gmail.com',
                'role' => 0,
                'password' => bcrypt('rahasia1234'),
                'status' => 'inactive',
                'satuan_kerja_id' => '2',
            ],
            [
                'username' => 'Admin',
                'name' => 'Admin',
                'email' => 'serbaserbissdunia@gmail.com',
                'role' => 1,
                'password' => bcrypt('rahasia1234'),
                'status' => 'active',
                'satuan_kerja_id' => '1',

            ],

        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
