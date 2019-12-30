<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWechatPayDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_pay_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pay_method_id');
            $table->string('app_id');
            $table->string('app_secret');
            $table->string('mch_id');
            $table->string('mch_api_key');
            $table->string('ssl_cert_path');
            $table->string('ssl_key_path');
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
        Schema::dropIfExists('wechat_pay_detail');
    }
}
