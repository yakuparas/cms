<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->string('tracking')->nullable();
            $table->string('comment')->nullable();
            $table->string('history')->nullable();
            $table->integer('user_id');
            $table->decimal('total',15,2)->default(0);
            $table->string('status')->default(\App\Enums\OrderStatus::Hazırlanıyor);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
