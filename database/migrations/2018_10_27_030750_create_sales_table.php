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
            $table->bigInteger('code_member')->unsigned()->default(0);
            $table->integer('total_item')->unsigned()->default(0);
            $table->bigInteger('total_price')->unsigned()->default(0);
            $table->integer('discount')->unsigned()->default(0);
            $table->bigInteger('pay')->unsigned()->default(0);
            $table->bigInteger('accepted')->unsigned()->default(0);
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
