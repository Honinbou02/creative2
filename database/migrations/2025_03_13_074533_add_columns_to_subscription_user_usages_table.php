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
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->tinyInteger('allow_facebook_platform')->default(0);
            $table->tinyInteger('allow_instagram_platform')->default(0);
            $table->tinyInteger('allow_twitter_platform')->default(0);
            $table->tinyInteger('allow_linkedin_platform')->default(0);
            $table->tinyInteger('allow_whatsapp_platform')->default(0);
            $table->tinyInteger('allow_pinterest_platform')->default(0);
            $table->tinyInteger('allow_youtube_platform')->default(0);

            $table->bigInteger('total_social_platform_account_per_month')->default(0);
            $table->bigInteger('total_social_platform_account_per_month_used')->default(0);
            $table->bigInteger('total_social_platform_account_per_month_remaining')->default(0);

            $table->bigInteger('total_social_platform_post_per_month')->default(0);
            $table->bigInteger('total_social_platform_post_per_month_used')->default(0);
            $table->bigInteger('total_social_platform_post_per_month_remaining')->default(0);
            
            $table->tinyInteger('allow_schedule_posting')->default(0);
            $table->tinyInteger('allow_ai_assistant')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->dropColumn([
                "allow_facebook_platform",
                "allow_instagram_platform",
                "allow_twitter_platform",
                "allow_linkedin_platform",
                "allow_whatsapp_platform",
                "allow_pinterest_platform",
                "allow_youtube_platform",
                "total_social_platform_account_per_month",
                "total_social_platform_account_per_month_used",
                "total_social_platform_account_per_month_remaining",
                "total_social_platform_post_per_month",
                "total_social_platform_post_per_month_used",
                "total_social_platform_post_per_month_remaining",
                "allow_schedule_posting",
                "allow_ai_assistant",
            ]);
        });
    }
};
