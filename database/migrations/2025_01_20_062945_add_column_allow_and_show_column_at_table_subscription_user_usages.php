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
            $table->tinyInteger('allow_ai_product_shot')->default(0)->after("allow_blog_wizard");
            $table->tinyInteger('allow_ai_photo_studio')->default(0)->after("allow_ai_product_shot");
            $table->tinyInteger('allow_ai_avatar_pro')->default(0)->after("allow_ai_photo_studio");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->dropColumn([
                "allow_ai_avatar_pro",
                "allow_ai_product_shot",
                "allow_ai_photo_studio",
            ]);
        });
    }
};
