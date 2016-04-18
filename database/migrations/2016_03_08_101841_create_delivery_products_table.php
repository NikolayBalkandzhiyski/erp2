<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('delivery_id');
            $table->integer('product_id');
            $table->double('product_count',15,9);
            $table->double('count_left',15,9);
            $table->float('product_price');
            $table->double('total',15,9);
            $table->string('ip');
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
        Schema::drop('delivery_products');
    }
}
