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
        Schema::table('wp_blog_posts', function (Blueprint $table) {
            $table->string("preview_post_url")->nullable()->after("website");
            $table->dateTime("date")->nullable()->after("preview_post_url");
            $table->tinyInteger("is_updated")->nullable()->comment("1=Existing Post, 2=New Post")->after("date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wp_blog_posts', function (Blueprint $table) {
            $table->dropColumn("preview_post_url");
            $table->dropColumn("date");
            $table->dropColumn("is_updated");
        });
    }
};
