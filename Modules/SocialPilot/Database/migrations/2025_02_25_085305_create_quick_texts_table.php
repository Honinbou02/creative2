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
        Schema::create('quick_texts', function (Blueprint $table) {
            $table->id();        
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            // common convention fields
            $table->tinyInteger("user_id");
            $table->tinyInteger("is_active")->default(1)->comment("1=Active, 0=Inactive");
            $table->foreignId("created_by_id")->nullable();
            $table->foreignId("updated_by_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
            // common convention fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_texts');
    }
};
