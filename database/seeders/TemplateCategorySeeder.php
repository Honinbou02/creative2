<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TemplateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('template_categories')->delete();

        $templateCategories = array(
            array('id' => '1','category_name' => 'Blog Contents','slug' => 'blog-contents-a1V3o4M0Z9Q2V7D','icon' => '<i class="las la-rss"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:04:56','deleted_at' => NULL),
            array('id' => '2','category_name' => 'Email Templates','slug' => 'email-templates','icon' => '<i class = "las la-envelope-open-text"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
            array('id' => '3','category_name' => 'Social Media','slug' => 'social-media','icon' => 'share-8','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => NULL,'updated_at' => '2025-01-27 05:53:55','deleted_at' => '2025-01-27 05:53:55'),
            array('id' => '4','category_name' => 'Videos','slug' => 'videos-I3K0Q8d1Q5x4D6E','icon' => '<i class="las la-video"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:05:48','deleted_at' => NULL),
            array('id' => '5','category_name' => 'Website Contents','slug' => 'website-contents-t8O1L0u3U9s8q0s','icon' => '<i class="las la-paragraph"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:07:25','deleted_at' => NULL),
            array('id' => '6','category_name' => 'General Contents','slug' => 'general-contents-o4Y9i8s8b7y2O6y','icon' => '<i class="las la-paragraph"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:07:48','deleted_at' => NULL),
            array('id' => '7','category_name' => 'Fun or Quote','slug' => 'fun-or-quote-N5Q6t3e0W4S7B0O','icon' => '<i class="las la-quote-left"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:08:40','deleted_at' => NULL),
            array('id' => '8','category_name' => 'Code','slug' => 'code-A2j4E7b6h1J5Y0M','icon' => '<i class="las la-code"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:09:41','deleted_at' => NULL),
            array('id' => '9','category_name' => 'Facebook','slug' => 'facebook-l2a5p4S2e5V7q7w','icon' => '<i class="lab la-facebook-f"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:11:09','deleted_at' => NULL),
            array('id' => '10','category_name' => 'Instagram','slug' => 'instagram-Z5Y1n7s8P7w5O5x','icon' => '<i class="lab la-instagram"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:11:42','deleted_at' => NULL),
            array('id' => '11','category_name' => 'Success Story','slug' => 'success-story-i4r0p8i8Z6m1T5t','icon' => '<i class="las la-history"></i>','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-01-27 06:13:06','deleted_at' => NULL),
            array('id' => '12','category_name' => 'SEO Tools','slug' => 'seo-tools','icon' => 'file-text','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
            array('id' => '13','category_name' => 'UX Article-2025','slug' => 'ux-article-2025-s9x2C6N9s4B3G4c','icon' => NULL,'is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2024-12-31 11:08:25','updated_at' => '2024-12-31 11:08:25','deleted_at' => NULL),
            array('id' => '14','category_name' => 'Test','slug' => 'test-l5j7x0j9Z9i8J2j','icon' => 'Test','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2025-01-04 05:14:54','updated_at' => '2025-01-04 05:15:00','deleted_at' => '2025-01-04 05:15:00'),
            array('id' => '15','category_name' => 'UX Article-2024','slug' => 'ux-article-2024-u4W1j1y6l8L3J7O','icon' => 'test','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2025-01-04 05:19:26','updated_at' => '2025-01-04 05:19:26','deleted_at' => NULL),
            array('id' => '16','category_name' => 'TT Category','slug' => 'tt-category-E7t5j8H8w4G2y0a','icon' => 'hash','is_active' => '1','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2025-01-21 12:55:02','updated_at' => '2025-01-21 12:55:02','deleted_at' => NULL)
        );

        DB::table('template_categories')->insert($templateCategories);
    }
}
