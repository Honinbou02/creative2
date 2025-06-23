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
            $table->boolean("allow_wordpress")->default(0)->after("allow_team");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->dropColumn("allow_wordpress");
        });
    }
};
