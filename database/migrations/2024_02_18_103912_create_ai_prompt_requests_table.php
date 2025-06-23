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
        Schema::create('ai_prompt_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId("engine_id")->constrained();
            $table->longText("prompt");
            $table->longText("ai_response")->nullable();
            $table->tinyInteger("is_completed")->default(1)->comment("1=Completed,0=Not Completed");

            $table->integer("total_words")->default(0);

            $table->integer("prompt_tokens")->default(0);
            $table->integer("completion_tokens")->default(0);
            $table->integer("token_used")->default(0);

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
        Schema::dropIfExists('ai_prompt_requests');
    }
};
