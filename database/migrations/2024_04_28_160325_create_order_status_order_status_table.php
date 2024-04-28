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
        Schema::create('order_status_order_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_status_id_1');
            $table->foreign('order_status_id_1')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('order_status_id_2');
            $table->foreign('order_status_id_2')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_order_status');
    }
};
