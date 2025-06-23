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
        Schema::table('articles', function (Blueprint $table) {
            $table->string("wp_media_url")->nullable()->after("selected_image");
            $table->dateTime("wp_synced_at")->nullable()->after("updated_by_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn("wp_media_url");
            $table->dropColumn("wp_synced_at");
        });
    }
};
