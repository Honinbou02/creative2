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
        Schema::create('user_sites', function (Blueprint $table) {
            $table->id();
            $table->string("url");
            $table->string("site_name")->nullable()->comment("Site Title/Name");
            $table->string("user_name");
            $table->string("password")->comment("Application Password");
            $table->tinyInteger("is_active")->default(0)->comment("1=Active,0=Inactive");
            $table->boolean('is_connection')->nullable()->default(false);
            $table->foreignId("user_id")->constrained();
            $table->foreignId("created_by_id")->nullable()->constrained("users");
            $table->foreignId("updated_by_id")->nullable()->constrained("users");
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sites');
    }
};
