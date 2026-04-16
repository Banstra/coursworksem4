<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('content');
            $table->timestamp('moderated_at')->nullable()->after('is_approved');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['moderated_by']);
            $table->dropColumn(['is_approved', 'moderated_at', 'moderated_by']);
        });
    }
};
