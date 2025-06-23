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
        Schema::create('ai_voices', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("Name of the voice");
            $table->string("voice_id")->comment("Voice ID");
            $table->string("platform")->comment("Elevenlabs or Huggingface or others");
            $table->string("model")->nullable();
            $table->foreignId("language_id")->nullable()->constrained();
            $table->tinyInteger("is_active")->default(1);
            $table->foreignId("user_id")->constrained();
            $table->foreignId("created_by_id")->nullable()->constrained("users");
            $table->foreignId("updated_by_id")->nullable()->constrained("users");
            $table->foreignId("deleted_by_id")->nullable()->constrained("users");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_voices');
    }
};
