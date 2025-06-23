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
            $table->text("selected_meta_description")->nullable()->after("title_generated_content_id");
            $table->foreignId("meta_description_generated_content_id")->nullable()->after("selected_meta_description")->constrained("generated_contents");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(["meta_description_generated_content_id"]);
            $table->dropColumn("meta_description_generated_content_id");
            $table->dropColumn("selected_meta_description");
        });
    }
};
