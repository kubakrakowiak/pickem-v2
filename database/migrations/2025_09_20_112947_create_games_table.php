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
        Schema::create('games', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('team_home');
            $table->string('team_away');
            $table->integer('score_home')->nullable();
            $table->integer('score_away')->nullable();
            $table->dateTime('start_at')->nullable()->index();
            $table->timestamps();

            $table->foreignUuid('pickem_id')
                  ->constrained('pickems')
                  ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
