<?php

namespace Database\Seeders;

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
        \App\Models\Admin\AccessControl\User::factory()->create([
            'name' => 'Kartic',
            'role_id' => 1,
            'status' => 1,
            'email' => 'dev.kartic@gmail.com',
        ]);

        \App\Models\Admin\AccessControl\User::factory(100000)->create();
    }
}
