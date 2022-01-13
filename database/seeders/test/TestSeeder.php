<?php

namespace ProwectCMS\Core\Database\Seeders\Test;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(FrontendUserSeeder::class);
    }
}