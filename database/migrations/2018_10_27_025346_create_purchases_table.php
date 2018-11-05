<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id_purchase');
            $table->integer('id_supplier')->unsigned();
            $table->integer('total_item')->unsigned()->default(0);
            $table->bigInteger('total_price')->unsigned()->default(0);
            $table->integer('discount')->unsigned()->default(0);
            $table->bigInteger('pay')->unsigned()->default(0);
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
        Schema::dropIfExists('purchases');
    }
}
