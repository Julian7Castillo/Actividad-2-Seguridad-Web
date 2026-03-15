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
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->boolean('is_home');
            $table->integer('pts_team');
            $table->integer('pts_op_team');
            $table->date('date_play');
            $table->string('name_op_team',128);
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
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
