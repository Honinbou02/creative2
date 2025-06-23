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
        Schema::create('ai_videos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("is_active")->default(1);

            $table->string("platform")->comment("Stable Diffusion/HeyGen");
            $table->string("model")->nullable();
            $table->foreignId("language_id")->nullable()->constrained("languages");
            $table->string("prompt")->nullable();

            $table->string('title');
            $table->string("voice_id")->nullable();
            $table->string("avatar_id")->nullable();
            $table->string("avatar_style")->nullable();
            $table->string("video_script")->nullable();
            $table->string("caption")->nullable();
            $table->string("matting")->nullable();
            $table->string("video_id")->nullable();
            $table->string("background_type")->nullable()->comment("Color/Image");
            $table->string("background_value")->nullable()->comment("Color Code/Image etc");
            $table->string("video_dimension")->nullable();

            $table->text("generated_thumbnail")->nullable();
            $table->text("generated_video_url")->nullable();
            $table->text("generated_video_gif_url")->nullable();
            $table->text("generated_video_url_caption")->nullable();
            $table->double("generated_video_duration")->default(0);
            $table->string("generated_video_status")->nullable();

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
        Schema::dropIfExists('ai_videos');
    }
};
