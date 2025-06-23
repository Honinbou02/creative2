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
        Schema::create('chat_threads', function (Blueprint $table) {
            $table->id();
            
            $table->string("type")->default("chat")->comment(typeInside());
            $table->string("title")->nullable();
            
            $table->integer("prompts_words")->default(0);
            $table->integer("completion_words")->default(0);
            $table->integer("total_words")->default(0);
            $table->integer("prompts_token")->default(0);
            $table->integer("completion_token")->default(0);
            $table->integer("total_token")->default(0);
            
            $table->foreignId("chat_expert_id")->nullable()->constrained();
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
        Schema::dropIfExists('chat_threads');
    }
};
