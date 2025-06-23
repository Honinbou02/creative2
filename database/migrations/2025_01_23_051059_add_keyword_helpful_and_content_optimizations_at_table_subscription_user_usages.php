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
            $table->double("total_seo_balance")->default(0.00)->after("word_balance_remaining_t2s");
            $table->double("seo_balance_used")->default(0.00)->after("total_seo_balance");
            $table->double("seo_balance_remaining")->default(0.00)->after("seo_balance_used");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_user_usages', function (Blueprint $table) {
            $table->dropColumn("total_seo_balance");
            $table->dropColumn("seo_balance_used");
            $table->dropColumn("seo_balance_remaining");
        });
    }
};
