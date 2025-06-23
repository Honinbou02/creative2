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
            $table->tinyInteger("article_source")->default(1)
                ->comment("1 = Generated from WriteRap, 2 = Imported from WordPress")
            ->after("article");
            $table->unsignedBigInteger("wp_post_id")->nullable()->after("article_source");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn("wp_post_id");
            $table->dropColumn("article_source");
        });
    }
};
