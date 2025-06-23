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
        Schema::table('role_permissions', function (Blueprint $table) {
            // Wrap in try-catch or check conditionally
            if (Schema::hasColumn('role_permissions', 'user_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $foreignKeys = $sm->listTableForeignKeys('role_permissions');
                foreach ($foreignKeys as $fk) {
                    if (in_array('user_id', $fk->getColumns())) {
                        $table->dropForeign($fk->getName());
                    }
                }
                $table->dropColumn('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->foreignId("user_id")->nullable()->constrained();
        });
    }
};
