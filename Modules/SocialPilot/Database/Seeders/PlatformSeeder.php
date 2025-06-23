<?php

namespace Modules\SocialPilot\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('platforms')->delete();
        
        DB::table('platforms')->insert(array(
            array (
                'id'    => 1,
                'name'  => 'Facebook',
                'slug'  => 'facebook',
            ),
            array (
                'id'    => 2,
                'name'  => 'Instagram',
                'slug'  => 'instagram',
            ),
            array (
                'id'    => 3,
                'name'  => 'Twitter/X',
                'slug'  => 'twitter',
            ),
            array (
                'id'    => 4,
                'name'  => 'LinkedIn',
                'slug'  => 'linkedin',
            ),
        )); 
    }
}
