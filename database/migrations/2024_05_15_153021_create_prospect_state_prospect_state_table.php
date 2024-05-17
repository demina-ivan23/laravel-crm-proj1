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
        Schema::create('prospect_state_prospect_state', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prospect_state_id_1');
            $table->foreign('prospect_state_id_1')->references('id')->on('prospect_states')->onDelete('cascade');
            $table->unsignedBigInteger('prospect_state_id_2');
            $table->foreign('prospect_state_id_2')->references('id')->on('prospect_states')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospect_state_prospect_state');
    }
};
