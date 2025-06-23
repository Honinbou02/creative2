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
        Schema::create('voices', function (Blueprint $table) {
            $table->id();
            $table->string('voice_id')->unique();
            $table->string('language')->nullable();
            $table->string('gender')->nullable();
            $table->string('name')->nullable();
            $table->text('preview_audio')->nullable();
            $table->string('support_pause')->nullable();
            $table->string('emotion_support')->nullable();
            $table->string('support_interactive_avatar')->nullable();
            
            $table->tinyInteger("is_active")->default(1)->comment("1=Active,0=Inactive");
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
        Schema::dropIfExists('voices');
    }
};
