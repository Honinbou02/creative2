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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->foreignId("blog_category_id")->nullable()->constrained("blog_categories");
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('blog_image')->nullable(); 
            $table->string('video_provider')->default('youtube')->comment('youtube / vimeo / ...');
            $table->text('video_link')->nullable();
            $table->tinyInteger('is_popular')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->integer('meta_image')->nullable();
            $table->longText('meta_description')->nullable();
            $table->foreignId("user_id")->constrained();
            $table->tinyInteger("is_active")->default(1)->comment("1=Active,0=Inactive");
            $table->foreignId("created_by_id")->nullable()->constrained("users");
            $table->foreignId("updated_by_id")->nullable()->constrained("users");
            $table->datetimes();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
