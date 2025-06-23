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
            $table->tinyInteger("show_ai_writer")->default(1)->after("show_templates");
            $table->tinyInteger("allow_ai_writer")->default(1)->after("show_ai_writer");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(["allow_ai_writer","show_ai_writer"]);
        });
    }
};
