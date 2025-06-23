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
        Schema::create('ai_writers', function (Blueprint $table) {
            $table->id();

            $table->string("title");
            $table->string("slug");
            $table->foreignId("user_id")->constrained();
            $table->string("language")->nullable();
            $table->string("model_name")->nullable()->comment("Model name");
            $table->longText("prompt")->nullable();
            $table->longText("response")->nullable();

            $table->integer("prompts_words")->default(0);
            $table->integer("completion_words")->default(0);
            $table->integer("total_words")->default(0);
            $table->integer("prompts_token")->default(0);
            $table->integer("completion_token")->default(0);
            $table->integer("total_token")->default(0);

            $table->foreignId("folder_id")->nullable()->constrained();

            $table->string("content_type")->nullable()->comment("content");
            $table->tinyInteger("platform")->nullable()->comment(platformInside());
            $table->unsignedBigInteger("article_id")->nullable();
            $table->foreignId("subscription_user_id")->nullable()->constrained();
            $table->foreignId("subscription_plan_id")->nullable()->constrained();
            $table->foreignId("template_id")->nullable()->constrained();

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
        Schema::dropIfExists('ai_writers');
    }
};
