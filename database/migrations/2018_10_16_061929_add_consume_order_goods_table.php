<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsumeOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consume_order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consume_order_id');
            $table->unsignedInteger('goods_id');
            $table->unsignedInteger('label_id')->nullable();
            $table->timestamps();

            $table->foreign('consume_order_id')
                ->references('id')
                ->on('consume_orders')
                ->onDelete('cascade');

            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consume_order_goods');
    }
}
