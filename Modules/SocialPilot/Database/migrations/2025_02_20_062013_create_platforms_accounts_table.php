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
        Schema::create('platforms_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->unsignedBigInteger('platform_id');
            $table->string('account_name');
            $table->string('account_id')->nullable();
            $table->longText('account_details')->nullable();
            $table->tinyInteger('account_type')->comment('0 => profile, 1 => page, 2 => group');
            $table->tinyInteger('is_connected')->default(0);
            $table->text('access_token')->nullable();
            $table->datetime('access_token_expire_at')->nullable();
            $table->text('refresh_token')->nullable();
            $table->datetime('refresh_token_expire_at')->nullable();
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
        Schema::dropIfExists('platforms_accounts');
    }
};
