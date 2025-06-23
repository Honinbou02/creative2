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
        Schema::create('user_balances', function (Blueprint $table) {
            $table->id();

            $table->foreignId("user_id")->constrained();
            
            
            $table->string("platform")->default(1)->comment(platformInside());
            $table->integer("word_balance")->default(0);
            $table->integer("image_balance")->default(0);
            $table->integer("speech_balance")->default(0);
            
            $table->tinyInteger("is_active")->default(0)->comment("1=Active,0=Inactive");
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balances');
    }
};
