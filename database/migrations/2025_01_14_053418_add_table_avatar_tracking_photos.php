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
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->string('avatar_id')->unique();
            $table->string('avatar_name')->nullable();
            $table->string('gender')->nullable();
            $table->text('preview_image_url', 1024)->nullable();
            $table->text('preview_video_url', 1024)->nullable();
            
            $table->tinyInteger("is_active")->default(1)->comment("1=Active, 0=Inactive");
            $table->foreignId("created_by_id")->nullable();
            $table->foreignId("updated_by_id")->nullable();
            $table->datetimes();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
