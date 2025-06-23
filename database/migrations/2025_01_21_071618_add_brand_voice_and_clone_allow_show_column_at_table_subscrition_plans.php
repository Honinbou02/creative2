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
            $table->integer("total_brand_voice")->default(0)->after("show_text_to_speech_open_ai");
            $table->tinyInteger("allow_brand_voice")->default(0)->after("total_brand_voice");
            $table->tinyInteger("show_brand_voice")->default(1)->after("allow_brand_voice");

            // Clone
            $table->tinyInteger("allow_clone_voice")->default(0)->after("show_brand_voice");
            $table->tinyInteger("show_clone_voice")->default(1)->after("allow_clone_voice");


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(["total_brand_voice","allow_brand_voice","allow_clone_voice","show_clone_voice","show_brand_voice"]);
        });
    }
};
