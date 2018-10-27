<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->increments('id_sales_detail');
            $table->integer('id_sales')->unsigned();       
            $table->bigInteger('product_code')->unsigned();         
            $table->bigInteger('selling_price')->unsigned();         
            $table->integer('total')->unsigned();    
            $table->integer('discount')->unsigned();                 
            $table->bigInteger('sub_total')->unsigned();    
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
        Schema::dropIfExists('sales_details');
    }
}