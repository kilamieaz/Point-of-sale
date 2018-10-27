<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id_sales');
            $table->bigInteger('member_code')->unsigned();            
            $table->integer('total_item')->unsigned();         
            $table->bigInteger('total_price')->unsigned();           
            $table->integer('discount')->unsigned();       
            $table->bigInteger('pay')->unsigned();     
            $table->bigInteger('be_accepted')->unsigned();     
            $table->integer('id_user')->unsigned();
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
        Schema::dropIfExists('sales');
    }
}