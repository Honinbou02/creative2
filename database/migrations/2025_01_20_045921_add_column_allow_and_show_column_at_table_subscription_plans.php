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
            $table->tinyInteger('allow_ai_product_shot')->default(0)->after("show_ai_code");
            $table->tinyInteger('show_ai_product_shot')->default(1)->after("allow_ai_product_shot");

            $table->tinyInteger('allow_ai_photo_studio')->default(0)->after("show_ai_product_shot");
            $table->tinyInteger('show_ai_photo_studio')->default(1)->after("allow_ai_photo_studio");

            $table->tinyInteger('allow_ai_avatar_pro')->default(0)->after("show_ai_photo_studio");
            $table->tinyInteger('show_ai_avatar_pro')->default(1)->after("allow_ai_avatar_pro");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                "allow_ai_avatar_pro",
                "show_ai_avatar_pro",

                "allow_ai_product_shot",
                "show_ai_product_shot",

                "allow_ai_photo_studio",
                "show_ai_photo_studio"
            ]);
        });
    }
};
