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
        Schema::create('article_s_e_o_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("article_id");
            $table->json("article_json");
            $table->json("seo_json")->nullable();
            $table->json("seo_request_body");
            $table->string("seo_operator_url");
            $table->unsignedBigInteger("created_by_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_s_e_o_s');
    }
};
