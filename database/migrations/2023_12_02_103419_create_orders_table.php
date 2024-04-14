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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->timestamps();
            $table->index('customer_id');

            $table->foreign('customer_id')
                ->references('id')->on('prospects')
                ->onDelete('CASCADE');
            $table->index('order_status');
            $table->foreign('order_status')
                ->references('id')->on('order_status')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
