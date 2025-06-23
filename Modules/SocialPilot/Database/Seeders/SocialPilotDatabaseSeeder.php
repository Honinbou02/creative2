<?php

namespace Modules\SocialPilot\Database\Seeders;

use Illuminate\Database\Seeder;

class SocialPilotDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PlatformSeeder::class,
        ]);
    }
}
