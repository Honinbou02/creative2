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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text("title")->nullable();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("subscription_user_id")->nullable()->constrained();
            $table->foreignId("subscription_plan_id")->nullable()->constrained();
            $table->integer("completed_step")->default(0);
            $table->text("topic")->nullable();
            $table->text("selected_keyword")->nullable();
            $table->foreignId("keyword_generated_content_id")->nullable()->constrained("generated_contents");
            $table->text("selected_title")->nullable();
            $table->foreignId("title_generated_content_id")->nullable()->constrained("generated_contents");
            $table->text("selected_outline")->nullable();
            $table->foreignId("outline_generated_content_id")->nullable()->constrained("generated_contents");
            $table->text("selected_image")->nullable();
            $table->longText("article")->nullable();
            $table->foreignId("article_generated_content_id")->nullable()->constrained("generated_contents");
            $table->integer("total_words")->default(0);
            $table->tinyInteger("is_published")->default(0)->comment("1=Published,0=Not Published");
            $table->tinyInteger("is_published_wordpress")->default(0)->comment("1=Published,0=Not Published");
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
        Schema::dropIfExists('articles');
    }
};
