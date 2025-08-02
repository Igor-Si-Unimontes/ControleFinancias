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
        Schema::table('spends', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->foreignId('category_id')->nullable()->constrained('category_spends')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spends', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
