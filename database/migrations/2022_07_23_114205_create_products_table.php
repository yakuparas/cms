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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brandID')->nullable();
            $table->foreignId('categoryID')->default(0);
            $table->foreignId('taxID')->nullable();
            $table->foreignId('currencyID')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('isVariable')->default(0);
            $table->tinyInteger('customize')->default(0);
            $table->string('model');
            $table->string('sku');
            $table->integer('quantity')->default(null)->nullable();
            $table->decimal('oldprice',15,4)->nullable()->default(null);
            $table->decimal('price',15,4)->nullable()->default(null);
            $table->decimal('discount_price',15,4)->nullable()->default(null);
            $table->decimal('purchase_price',15,4)->nullable()->default(null);
            $table->decimal('purchase_discount',15,4)->nullable()->default(null);
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('weight',15,4)->nullable()->default(null);
            $table->decimal('length',15,4)->nullable()->default(null);
            $table->decimal('width',15,4)->nullable()->default(null);
            $table->decimal('height',15,4)->nullable()->default(null);
            $table->string('tag')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('products');
    }
};
