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
            $table->tinyInteger('show_facebook_platform')->default(1);
            $table->tinyInteger('allow_facebook_platform')->default(1);
            $table->tinyInteger('show_instagram_platform')->default(1);
            $table->tinyInteger('allow_instagram_platform')->default(1);
            $table->tinyInteger('show_twitter_platform')->default(1);
            $table->tinyInteger('allow_twitter_platform')->default(0);
            $table->tinyInteger('show_linkedin_platform')->default(1);
            $table->tinyInteger('allow_linkedin_platform')->default(0);
            $table->tinyInteger('show_whatsapp_platform')->default(0);

            $table->tinyInteger('allow_whatsapp_platform')->default(0);
            $table->tinyInteger('show_pinterest_platform')->default(0);
            $table->tinyInteger('allow_pinterest_platform')->default(0);
            $table->tinyInteger('show_youtube_platform')->default(0);
            $table->tinyInteger('allow_youtube_platform')->default(0);

            $table->bigInteger('total_social_platform_account_per_month')->default(10);
            $table->tinyInteger('show_total_social_platform_account')->default(1);
            
            $table->bigInteger('total_social_platform_post_per_month')->default(10);
            $table->tinyInteger('show_total_social_platform_post')->default(1);
            
            $table->tinyInteger('show_schedule_posting')->default(1);
            $table->tinyInteger('allow_schedule_posting')->default(1);
            
            $table->tinyInteger('show_ai_assistant')->default(1);
            $table->tinyInteger('allow_ai_assistant')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                "show_facebook_platform",
                "allow_facebook_platform",
                "show_instagram_platform",
                "allow_instagram_platform",
                "show_twitter_platform",
                "allow_twitter_platform",
                "show_linkedin_platform",
                "allow_linkedin_platform",
                "show_whatsapp_platform",
                "allow_whatsapp_platform",
                "show_pinterest_platform",
                "allow_pinterest_platform",
                "show_youtube_platform",
                "allow_youtube_platform",
                "total_social_platform_account_per_month",
                "show_total_social_platform_account",
                "total_social_platform_post_per_month",
                "show_total_social_platform_post",
                "show_schedule_posting",
                "allow_schedule_posting",
                "show_ai_assistant",
                "allow_ai_assistant",
            ]);
        });
    }
};
