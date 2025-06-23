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
        Schema::table('wp_authors', function (Blueprint $table) {
            $table->unsignedBigInteger("wp_user_id")->nullable()->after("id");
            $table->dropUnique("wp_authors_email_unique");
            $table->dropUnique("wp_authors_username_unique");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wp_authors', function (Blueprint $table) {
            $table->dropColumn("wp_user_id");
            $table->unique("email","username");
        });
    }
};
