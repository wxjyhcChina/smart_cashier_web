<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('card_id')->nullable();
            $table->unsignedInteger('account_id');
            $table->string('type');
            $table->unsignedInteger('recharge_order_id')->nullable();
            $table->unsignedInteger('consume_order_id')->nullable();
            $table->double('money', 10, 2);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('card_id')
                ->references('id')
                ->on('cards')
                ->onDelete('cascade');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->foreign('recharge_order_id')
                ->references('id')
                ->on('recharge_orders')
                ->onDelete('cascade');

            $table->foreign('consume_order_id')
                ->references('id')
                ->on('consume_orders')
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
        Schema::dropIfExists('account_records');
    }
}
