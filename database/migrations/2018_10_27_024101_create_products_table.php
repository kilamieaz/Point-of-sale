<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id_product');
            $table->increments('product_code')->unsigned();
            $table->integer('id_category')->unsigned();           
            $table->string('product_name', 100);           
            $table->string('brand', 50);             
            $table->bigInteger('purchase_price')->unsigned();         
            $table->integer('discount')->unsigned();             
            $table->bigInteger('selling_price')->unsigned();          
            $table->integer('stock')->unsigned();   
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