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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger("has_monthly_limit")->default(0)->comment("Applicable for the yearly & lifetime package only. Not applicable for the prepaid/monthly");
            $table->string("title");
            $table->string("slug");
            $table->foreignId("user_id")->constrained();
            $table->integer('duration')->nullable()->default(30);
            $table->string('openai_model');
            $table->string('description')->nullable();
            $table->string('package_type')->default('monthly')->comment('starter/monthly/yearly/lifetime/prepaid');
            $table->double('price')->default('0.00');
            $table->double('discount_price')->nullable();
            $table->integer('discount_type')->nullable()->comment('1=fixed, 2=percentage');
            $table->double('discount')->nullable();
            $table->integer('discount_status')->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->bigInteger('total_words_per_month')->default(0);
            $table->bigInteger('speech_to_text_filesize_limit')->default(1); 
            $table->tinyInteger('allow_words')->default(1);
            $table->tinyInteger('show_words')->default(1);
            $table->tinyInteger('allow_unlimited_word')->nullable()->default(0);
            $table->tinyInteger('allow_text_to_speech')->default(0);
            $table->tinyInteger('show_text_to_speech')->default(1);
            $table->tinyInteger('allow_ai_code')->default(0);
            $table->tinyInteger('show_ai_code')->default(1);
            $table->bigInteger('total_text_to_speech_per_month')->default(0);            
            $table->tinyInteger('allow_unlimited_text_to_speech')->nullable()->default(0);
            $table->tinyInteger('allow_text_to_speech_open_ai')->nullable()->default(0);            
            $table->tinyInteger('show_text_to_speech_open_ai')->default(1);
            $table->tinyInteger('allow_google_cloud')->default(0);
            $table->tinyInteger('show_google_cloud')->default(1);
            $table->tinyInteger('allow_azure')->default(0);
            $table->tinyInteger('show_azure')->default(1);
            $table->tinyInteger('allow_unlimited_ai_video')->nullable()->default(0);
            $table->bigInteger('total_ai_video_per_month')->default(0);      
            $table->tinyInteger('allow_ai_video')->default(0);
            $table->tinyInteger('show_ai_video')->default(0);
            $table->tinyInteger('allow_ai_chat')->default(0);
            $table->tinyInteger('show_ai_chat')->default(1);
            $table->tinyInteger('allow_templates')->default(1);
            $table->tinyInteger('show_templates')->default(1);
            $table->tinyInteger('allow_ai_rewriter')->default(0);
            $table->tinyInteger('show_ai_rewriter')->default(0);
            $table->tinyInteger('allow_ai_detector')->nullable()->default(1);
            $table->tinyInteger('show_ai_detector')->nullable()->default(0);
            $table->tinyInteger('allow_ai_plagiarism')->nullable()->default(1);           
            $table->tinyInteger('show_ai_plagiarism')->nullable()->default(1);            
            $table->tinyInteger('allow_ai_image_chat')->default(0);
            $table->tinyInteger('show_ai_image_chat')->default(0);
            $table->bigInteger('total_speech_to_text_per_month')->default(0);
            $table->tinyInteger('allow_speech_to_text')->default(0);
            $table->tinyInteger('show_speech_to_text')->default(1);
            $table->tinyInteger('allow_unlimited_speech_to_text')->nullable()->default(0);
            $table->bigInteger('total_images_per_month')->default(0);
            $table->tinyInteger('allow_unlimited_image')->nullable()->default(0);
            $table->tinyInteger('allow_images')->default(1);
            $table->tinyInteger('show_images')->default(1);
            $table->tinyInteger('allow_sd_images')->default(1);
            $table->tinyInteger('show_sd_images')->default(1);
            $table->tinyInteger('allow_dall_e_2_image')->nullable()->default(1);
            $table->tinyInteger('show_dall_e_2_image')->nullable()->default(1);
            $table->tinyInteger('allow_dall_e_3_image')->nullable()->default(1);
            $table->tinyInteger('show_dall_e_3_image')->nullable()->default(1);
            $table->tinyInteger('allow_ai_pdf_chat')->default(0);
            $table->tinyInteger('show_ai_pdf_chat')->default(0);
            $table->tinyInteger('allow_eleven_labs')->nullable()->default(0);
            $table->tinyInteger('show_eleven_labs')->nullable()->default(0);
            $table->tinyInteger('allow_real_time_data')->nullable()->default(0);
            $table->tinyInteger('show_real_time_data')->nullable()->default(0); 
            $table->tinyInteger('allow_blog_wizard')->nullable()->default(1);
            $table->tinyInteger('show_blog_wizard')->nullable()->default(0); 
            $table->tinyInteger('allow_ai_vision')->default(0);
            $table->tinyInteger('show_ai_vision')->default(0);
            $table->tinyInteger('allow_team')->default(0);
            $table->tinyInteger('show_team')->default(0);
            $table->tinyInteger('show_open_ai_model')->default(1);  
            $table->tinyInteger('show_live_support')->default(1);
            $table->tinyInteger('show_free_support')->default(1);
            $table->tinyInteger('has_live_support')->default(0);
            $table->tinyInteger('has_free_support')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->longText('other_features')->nullable();            
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
        Schema::dropIfExists('subscription_plans');
    }
};
