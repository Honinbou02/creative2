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
        Schema::create('wp_blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("article_id")->constrained();
            $table->string('website');
            $table->json('tags')->nullable();
            $table->json('categories')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('featured_media')->nullable();
            $table->integer('wp_id')->nullable();
            $table->string('status')->nullable();
            $table->foreignId("user_site_id")->nullable()->constrained();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("created_by_id")->nullable()->constrained("users");
            $table->foreignId("updated_by_id")->nullable()->constrained("users");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_blog_posts');
    }
};
