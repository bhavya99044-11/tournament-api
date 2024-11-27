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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('opponent_team_id');
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('result_id')->nullable();
            $table->date('match_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('round');
            $table->string('status');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_matches');
    }
};
