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
            $table->tinyInteger("total_brand_voice")->default(0)->after("allow_text_to_speech_open_ai");
            $table->tinyInteger("allow_brand_voice")->default(0)->after("total_brand_voice");

            // Clone
            $table->tinyInteger("allow_clone_voice")->default(0)->after("allow_brand_voice");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->dropColumn([
                "total_brand_voice",
                "allow_brand_voice",
                "allow_clone_voice",
            ]);
        });
    }
};
