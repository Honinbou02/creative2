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
        Schema::create('subscription_user_usages', function (Blueprint $table) {
            $table->id();

            $table->foreignId("user_id")->constrained();
            $table->foreignId("subscription_user_id")->constrained();
            $table->foreignId("subscription_plan_id")->constrained();
            $table->integer("subscription_status")->nullable()->comment('1=active, 2=expired, 3=subscribed, 4=pending');

            $table->string("platform")->default(1)->comment(platformInside());

            $table->tinyInteger("has_monthly_limit")->default(0)->comment("Applicable for the yearly & lifetime package only. Not applicable for the prepaid/monthly");

            $table->dateTime("start_at");
            $table->dateTime("expire_at");

            $table->string("openai_model")->nullable();
            $table->integer("word_balance")->default(0);
            $table->integer("word_balance_used")->default(0);
            $table->integer("word_balance_remaining")->default(0);

            $table->integer("word_balance_t2s")->default(0);
            $table->integer("word_balance_used_t2s")->default(0);
            $table->integer("word_balance_remaining_t2s")->default(0);

            $table->integer("image_balance")->default(0);
            $table->integer("image_balance_used")->default(0);
            $table->integer("image_balance_remaining")->default(0);

            $table->integer("video_balance")->default(0);
            $table->integer("video_balance_used")->default(0);
            $table->integer("video_balance_remaining")->default(0);

            $table->integer("speech_balance")->default(0);
            $table->integer("speech_balance_used")->default(0);
            $table->integer("speech_balance_remaining")->default(0);

            $table->tinyInteger('allow_unlimited_word')->nullable()->default(0);
            $table->tinyInteger('allow_unlimited_text_to_speech')->nullable()->default(0);
            $table->tinyInteger('allow_unlimited_image')->nullable()->default(0);
            $table->tinyInteger('allow_unlimited_speech_to_text')->nullable()->default(0);
            $table->tinyInteger('allow_unlimited_ai_video')->nullable()->default(0);
            $table->bigInteger('speech_to_text_filesize_limit')->nullable(); 
            $table->tinyInteger('allow_words')->default(1);
            $table->tinyInteger('allow_ai_code')->default(0);
            $table->tinyInteger('allow_ai_chat')->default(0);
            $table->tinyInteger('allow_ai_pdf_chat')->default(0);
            $table->tinyInteger('allow_templates')->default(0);
            $table->tinyInteger('allow_ai_rewriter')->default(0);
            $table->tinyInteger('allow_ai_detector')->nullable()->default(0);
            $table->tinyInteger('allow_ai_plagiarism')->nullable()->default(0);           
            $table->tinyInteger('allow_real_time_data')->nullable()->default(0);
            $table->tinyInteger('allow_blog_wizard')->nullable()->default(0);
            $table->tinyInteger('allow_text_to_speech')->default(0);
            $table->tinyInteger('allow_text_to_speech_open_ai')->nullable()->default(0);            
            $table->tinyInteger('allow_google_cloud')->default(0);
            $table->tinyInteger('allow_azure')->default(0);
            $table->tinyInteger('allow_eleven_labs')->nullable()->default(0);
            $table->tinyInteger('allow_ai_video')->default(0);
            $table->tinyInteger('allow_speech_to_text')->default(0);
            $table->tinyInteger('allow_images')->default(0);
            $table->tinyInteger('allow_ai_image_chat')->default(0);
            $table->tinyInteger('allow_sd_images')->default(0);
            $table->tinyInteger('allow_dall_e_2_image')->nullable()->default(0);
            $table->tinyInteger('allow_dall_e_3_image')->nullable()->default(0);
            $table->tinyInteger('allow_ai_vision')->default(0);
            $table->tinyInteger('allow_team')->default(0);
            $table->tinyInteger('has_free_support')->default(0);
            
            $table->tinyInteger("is_active")->default(0)->comment("1=Active,0=Inactive");
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
        Schema::dropIfExists('subscription_user_usages');
    }
};
