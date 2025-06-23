<?php

namespace Database\Seeders;

use App\Models\AdSense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdSenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ad_senses')->delete();
        $ad_senses = array(
            array('id' => '1','slug' => 'header-top','size' => '728x90','name' => 'Header Top','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '2','slug' => 'top-feature-section','size' => '728x90','name' => 'Top Feature Section','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '3','slug' => 'top-best-feature','size' => '728x90','name' => 'Top Best Feature','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '4','slug' => 'top-template-section','size' => '728x90','name' => 'Top Template Section','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '5','slug' => 'top-review-section','size' => '728x90','name' => 'Top Review Section','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '6','slug' => 'top-subscription-package','size' => '728x90','name' => 'Top Subscription Package','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '7','slug' => 'top-trail-banner-section','size' => '728x90','name' => 'Top Trail Banner Section','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10'),
            array('id' => '8','slug' => 'top-footer-section','size' => '728x90','name' => 'Top Footer Section','code' => NULL,'is_active' => '0','user_id' => '1','created_by_id' => NULL,'updated_by_id' => NULL,'created_at' => '2024-07-02 06:48:10','updated_at' => '2024-07-02 06:48:10')
        );
        DB::table('ad_senses')->insert($ad_senses);
    }
}
