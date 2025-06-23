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
        Schema::create('chat_thread_messages', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("chat_expert_id")->nullable()->constrained();
            $table->foreignId("chat_thread_id")->nullable()->constrained();
            $table->string("platform")->nullable()->comment(platformInside());
            $table->string("type")->default("chat")->comment(typeInside());
            $table->string("random_number")->nullable()->unique()->comment("random number will help us to update user balance.");
            
            $table->longText("title")->nullable();
            $table->longText("response")->nullable();
            $table->longText("prompt")->nullable();
            $table->longText("revers_prompt")->nullable();
            $table->string("file_path")->nullable();
            $table->longText("file_content")->nullable();
            $table->longText("file_embedding_content")->nullable();
            $table->longText("prompt_embedding_content")->nullable();
            
            
            $table->integer("prompts_words")->default(0);
            $table->integer("completion_words")->default(0);
            $table->integer("total_words")->default(0);
            $table->integer("prompts_token")->default(0);
            $table->integer("completion_token")->default(0);
            $table->integer("total_token")->default(0);
            $table->foreignId("generated_image_id")->nullable()->constrained("generated_images");
            
            $table->foreignId("subscription_user_id")->nullable()->constrained();
            $table->foreignId("subscription_plan_id")->nullable()->constrained();
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
        Schema::dropIfExists('chat_thread_messages');
    }
};
