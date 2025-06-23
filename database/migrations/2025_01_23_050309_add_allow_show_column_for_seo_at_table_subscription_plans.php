<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {

            $table->double("total_seo_balance_per_month")->default(0.00)->after("discount_end_date");
            $table->boolean("allow_seo")->default(0)->after("total_seo_balance_per_month");
            $table->boolean("show_seo")->default(0)->after("allow_seo");
            //Keywords
            $table->boolean("show_seo_keyword")->default(1)->after("total_seo_balance_per_month");
            $table->boolean("allow_seo_keyword")->default(0)->after("show_seo_keyword");

            // Helpful Content
            $table->boolean("show_seo_helpful_content")->default(1)->after("allow_seo_keyword");
            $table->boolean("allow_seo_helpful_content")->default(0)->after("show_seo_helpful_content");

            // Content Optimizations
            $table->boolean("show_seo_content_optimization")->default(1)->after("allow_seo_helpful_content");
            $table->boolean("allow_seo_content_optimization")->default(0)->after("show_seo_content_optimization");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn("total_seo_balance_per_month");
            $table->dropColumn("allow_seo");
            $table->dropColumn("show_seo");

            $table->dropColumn("show_seo_keyword");
            $table->dropColumn("allow_seo_keyword");

            $table->dropColumn("show_seo_helpful_content");
            $table->dropColumn("allow_seo_helpful_content");

            $table->dropColumn("show_seo_content_optimization");
            $table->dropColumn("allow_seo_content_optimization");
        });
    }
};
