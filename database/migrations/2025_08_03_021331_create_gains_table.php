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
        Schema::create('gains', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gains', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('gains');
    }
};
