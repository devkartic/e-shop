<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Kartic',
            'role_id' => 1,
            'status' => 1,
            'email' => 'dev.kartic@gmail.com',
        ]);

        \App\Models\User::factory(999)->create();
    }
}
