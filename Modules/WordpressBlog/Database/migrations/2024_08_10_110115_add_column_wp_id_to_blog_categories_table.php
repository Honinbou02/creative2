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
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->foreignId("user_site_id")->nullable()->constrained()->after('parent_category_id');
            $table->integer('wp_id')->nullable()->after('user_site_id');  
            $table->integer('is_wp_sync')->nullable()->default(0)->comment("1=WP Sync, 0=Not WP Sync")->after('wp_id');  

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $columns = ['wp_id', 'user_site_id'];
            $table->dropColumn($columns);
        });
    }
};
