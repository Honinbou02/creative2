<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\PaymentGatewaySeed;
use Database\Seeders\StorageManagerSeeder;
use Database\Seeders\SubscriptionPlanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MediaManagerSeeder::class,
            AiChatExpertSeeder::class,
            SubscriptionPlanSeeder::class,
            PaymentGatewaySeed::class,
            StorageManagerSeeder::class,
            TemplateCategorySeeder::class,
            TemplateSeeder::class,
            CurrencySeeder::class,
            LanguageSeeder::class,
            AdSenseSeeder::class,
            EmailTemplateSeeder::class,
            FAQSeeder::class,
            ModuleSeeder::class,
            SystemSettingSeeder::class,
            PermissionSeeder::class,
            PageSeeder::class,
        ]);
    }
}