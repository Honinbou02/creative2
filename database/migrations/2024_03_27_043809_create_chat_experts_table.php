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
        Schema::create('chat_experts', function (Blueprint $table) {
            $table->id();
            $table->string("expert_name");
            $table->string("short_name")->nullable();
            $table->string("slug")->nullable();
            $table->text("description")->nullable();
            $table->string("role")->nullable();
            $table->string("assists_with")->nullable();
            $table->longText("chat_training_data")->nullable();
            $table->string("avatar")->nullable();
            $table->string("type")->nullable()->comment("chat/pdf/vision/image");
            $table->tinyInteger("is_deletable")->nullable()->default(1)->comment("1=yes,0=no");
            $table->tinyInteger("is_active")->default(1)->comment("1=Active,0=Inactive");
            $table->foreignId("user_id")->constrained();
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
        Schema::dropIfExists('chat_experts');
    }
};
