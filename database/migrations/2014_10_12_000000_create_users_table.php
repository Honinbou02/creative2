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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_user_id')->nullable()->constrained("users");
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_no')->nullable();
            $table->tinyInteger('user_type')->comment("1 = Admin, 2 = Admin Staff, 3 = customer, 4 = customer team");
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('verification_code_expired_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_type')->nullable();
            $table->double('user_balance')->default('0.00');
            $table->string('referral_code')->nullable();
            $table->integer('num_of_clicks')->default(0);
            $table->string('referred_user_id')->nullable();
            $table->tinyInteger('is_commission_calculated')->default(1);
            $table->rememberToken();
            
            $table->tinyInteger("is_active")->default(1)->comment("1=Active,0=Inactive");
            $table->foreignId("created_by_id")->nullable()->constrained("users")->after('created_at');
            $table->foreignId("updated_by_id")->nullable()->constrained("users")->after('updated_at');
            $table->datetimes();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
