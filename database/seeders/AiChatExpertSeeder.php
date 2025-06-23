<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AiChatExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chat_experts')->delete();
        $chat_experts = array(
            array('id' => '1','expert_name' => 'AI Chat Bot','short_name' => 'Bot','slug' => 'ai-chat-bot','description' => 'Chat With AI','role' => 'General','assists_with' => 'Generated content','chat_training_data' => NULL,'avatar' => NULL,'type' => 'chat','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2024-08-24 05:09:32','updated_at' => '2024-08-24 05:09:32','is_active' => '1','deleted_at' => NULL, 'is_deletable'=>0),
            array('id' => '2','expert_name' => 'AI Chat Image','short_name' => 'Image','slug' => 'ai-chat-image','description' => 'Chat With AI','role' => 'General','assists_with' => 'Generated content','chat_training_data' => NULL,'avatar' => NULL,'type' => 'image','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2024-08-24 05:09:32','updated_at' => '2024-08-24 05:09:32','is_active' => '1','deleted_at' => NULL, 'is_deletable'=>0),
            array('id' => '3','expert_name' => 'AI Vision','short_name' => 'Vision','slug' => 'ai-vision','description' => 'Chat With AI','role' => 'General','assists_with' => 'Generated content','chat_training_data' => NULL,'avatar' => NULL,'type' => 'vision','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2024-08-24 05:09:32','updated_at' => '2024-08-24 05:09:32','is_active' => '1','deleted_at' => NULL, 'is_deletable'=>0),
            array('id' => '4','expert_name' => 'AI PDF Chat','short_name' => 'PDF','slug' => 'ai-pdf-chat','description' => 'Chat With AI','role' => 'General','assists_with' => 'Generated content','chat_training_data' => NULL,'avatar' => NULL,'type' => 'pdf','user_id' => '1','created_by_id' => '1','updated_by_id' => NULL,'created_at' => '2024-08-24 05:09:32','updated_at' => '2024-08-24 05:09:32','is_active' => '1','deleted_at' => NULL, 'is_deletable'=>0),
          );

        DB::table('chat_experts')->insert($chat_experts);
          
    }
}
