<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerOperationRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_operation_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('card_id');
            $table->string('operation');
            $table->string('remark');
            $table->timestamps();

            $table->foreign('operator_id')
                ->references('id')
                ->on('restaurant_users')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('card_id')
                ->references('id')
                ->on('cards')
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
        Schema::dropIfExists('customer_operation_records');
    }
}
