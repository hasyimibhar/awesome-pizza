<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_id')->unsigned();
            $table->integer('pizza_id')->unsigned();
            $table->integer('crust_id')->unsigned();
            $table->integer('size_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('pizza_id')->references('id')->on('pizzas');
            $table->foreign('crust_id')->references('id')->on('crusts');
            $table->foreign('size_id')->references('id')->on('serving_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
