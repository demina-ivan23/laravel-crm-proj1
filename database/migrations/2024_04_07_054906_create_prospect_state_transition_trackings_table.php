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
        Schema::create('prospect_state_transition_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prospect_id');
            $table->index('prospect_id');
            $table->foreign('prospect_id')
            ->references('id')
            ->on('prospects');
            $table->unsignedBigInteger('state_id');
            $table->index('state_id');
            $table->foreign('state_id')
            ->references('id')
            ->on('prospect_states');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospect_transition_trackings');
    }
};
