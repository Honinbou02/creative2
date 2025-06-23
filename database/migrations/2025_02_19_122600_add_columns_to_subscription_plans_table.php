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
            $table->boolean("show_wordpress")->default(0)->after("allow_seo_content_optimization");
            $table->boolean("allow_wordpress")->default(0)->after("show_wordpress");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn("show_wordpress");
            $table->dropColumn("allow_wordpress");
        });
    }
};
