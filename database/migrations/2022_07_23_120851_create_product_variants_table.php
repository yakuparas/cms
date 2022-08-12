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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->integer("categoryID");
            $table->integer("productID");
            $table->string("name");
            $table->string('sku',255)->unique();
            $table->integer('quantity')->default(0);
            $table->decimal('oldprice', 15,4);
            $table->decimal('price',15,4)->default(0);
            $table->decimal('discount_price',15,4)->nullable();
            $table->decimal('purchase_price',15,4)->nullable();
            $table->decimal('purchase_discount',15,4)->nullable();
            $table->string("image");
            $table->integer('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('uniqID')->unique();
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
        Schema::dropIfExists('product_variants');
    }
};
