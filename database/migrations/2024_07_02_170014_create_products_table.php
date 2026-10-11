<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->unsignedBigInteger('category_id')->index();
            $table->string('name')->nullable();
            $table->string('details');
            $table->integer('purchase_price');
            $table->integer('selling_price');
            $table->integer('alert_quantity');
            $table->integer('sku')->nullable();
            $table->string('image');
            $table->json('thumbnail');
            $table->string('barcode')->unique();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('brand_id')
                ->nullable()
                ->nullOnDelete();

            $table->foreignId('unit_id')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
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
}
