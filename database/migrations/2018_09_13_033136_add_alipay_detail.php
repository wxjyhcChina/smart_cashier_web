<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlipayDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alipay_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pay_method_id');
            $table->string('app_id');
            $table->string('pid');
            $table->string('pub_key_path');
            $table->string('mch_private_key_path');
            $table->timestamps();

            $table->foreign('pay_method_id')
                ->references('id')
                ->on('pay_methods')
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
        Schema::dropIfExists('alipay_detail');
    }
}
