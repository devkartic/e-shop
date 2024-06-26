<?php

namespace Database\Seeders;

use App\Models\Admin\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    protected $modules = [
        ['name' => 'Home'],
        ['name' => 'Auth'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->modules as $module) { Module::create($module); }
    }
}
