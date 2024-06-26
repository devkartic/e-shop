<?php

namespace Database\Seeders;

use App\Models\Admin\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    protected $links = [
        [
            'name' => 'Dashboard',
            'url' => 'dashboard',
            'module_id' => 1
        ],
        [
            'name' => 'Roles',
            'url' => 'roles',
            'module_id' => 2
        ],
        [
            'name' => 'Users',
            'url' => 'users',
            'module_id' => 2
        ],
        [
            'name' => 'Permissions',
            'url' => 'permissions',
            'module_id' => 2
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->links as $link) { Link::create($link); }
    }
}
