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
        Schema::create('text_to_speeches', function (Blueprint $table) {
            $table->id();
            
            $table->string("title");
            $table->string("slug");
            $table->string("model")->nullable();
            $table->string("language")->nullable();
            $table->string("voice")->nullable();
            $table->string("speed")->nullable();
            $table->string("break")->nullable();
            $table->longText("text")->nullable();
            $table->longText("response")->nullable();
            $table->text("speech")->nullable();
            $table->text("file_path")->nullable();
            $table->text("audioName")->nullable();
            $table->text("hash")->nullable();
            $table->string("credits")->nullable();
            $table->string("words")->nullable();
            $table->string("storage_type")->nullable()->comment("local/aws");
            $table->string("type")->nullable()->comment(platformInside());
            $table->foreignId("subscription_user_id")->nullable()->constrained();
            $table->foreignId("subscription_plan_id")->nullable()->constrained();
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
        Schema::dropIfExists('text_to_speeches');
    }
};
