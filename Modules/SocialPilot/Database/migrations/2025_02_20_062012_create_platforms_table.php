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
        Schema::create('platforms', function (Blueprint $table) {$table->id();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('icon_media_manager_id')->nullable();
            $table->longText('credentials')->nullable();
            // common convention fields
            $table->tinyInteger("is_active")->default(1)->comment("1=Active, 0=Inactive");
            $table->tinyInteger("is_integrated")->default(1)->comment("1=Integrated, 0=Not Integrated");
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
        Schema::dropIfExists('platforms');
    }
};
