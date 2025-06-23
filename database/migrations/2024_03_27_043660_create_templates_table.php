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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();

            
            $table->tinyInteger("is_default")->default(1)->comment("Inbuilt Templates. is_default = 1, Custom Templates = 0");
            $table->tinyInteger("is_favourite")->default(0);
            $table->tinyInteger("is_popular")->default(0);            
            $table->string("template_name"); 
            $table->longText("description")->nullable();
            $table->string("slug")->nullable();
            $table->string("icon")->nullable();
            $table->longText("fields")->nullable();
            $table->longText("prompt")->nullable();
            $table->bigInteger("total_words_generated")->default(0);
            $table->bigInteger("total_view")->default(0);
            $table->bigInteger("total_favourite")->default(0);
            $table->string("code")->nullable()->comment("TODO:: WHAT IS THE USE OF THIS FIELD?");            
            $table->foreignId("template_category_id")->constrained();
            $table->foreignId("user_id")->constrained();            
            $table->tinyInteger("is_active")->default(1)->comment("1=Active,0=Inactive");
            $table->foreignId("created_by_id")->nullable()->constrained("users");
            $table->foreignId("updated_by_id")->nullable()->constrained("users");
            $table->datetimes();
            $table->softDeletes();

            $table->unique(["slug", "user_id"],"idx_user_slug");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
