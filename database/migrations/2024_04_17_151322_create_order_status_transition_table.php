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
        Schema::create('order_status_transition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained()->onDelete('cascade');
            $table->string('expalanation')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('default_order_transition_id');
            $table->index('default_order_transition_id');
            $table->foreign('default_order_transition_id')
            ->references('id')
            ->on('order_statuses')
            ->nullable()
            ->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_transition');
    }
};
