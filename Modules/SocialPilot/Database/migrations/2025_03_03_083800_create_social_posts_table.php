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
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('subscription_plan_id')->nullable();
            $table->bigInteger('platform_id');
            $table->bigInteger('platform_account_id');
            $table->tinyInteger('post_type')->comment('1 => feed, 2 = story, 3 => reel');
            $table->longText('details')->nullable();
            $table->text('media_manager_ids')->nullable();
            $table->text('external_link')->nullable();
            $table->tinyInteger('post_status')->comment('1 => draft, 2 = pending, 3 => successful, 4 => scheduled, 5 => failed');
            $table->tinyInteger('is_scheduled')->default(0)->comment('0 => No, 1 = yes');
            $table->dateTime('schedule_time')->nullable();
            $table->longText('platform_api_response')->nullable();

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
        Schema::dropIfExists('social_posts');
    }
};
