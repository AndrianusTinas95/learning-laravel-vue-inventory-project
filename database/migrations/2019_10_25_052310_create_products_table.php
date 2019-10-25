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
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->string('serial');
            $table->boolean('status')->default(1);
            $table->interger('brand_id')->nullable()->unsigned();
            $table->interger('manufacture_id')->nullable()->unsigned();
            $table->interger('category_id')->nullable()->unsigned();
            $table->interger('description_id')->nullable()->unsigned();
            $table->interger('location_id')->nullable()->unsigned();
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
}
