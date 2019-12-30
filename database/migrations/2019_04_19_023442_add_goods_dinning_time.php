<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoodsDinningTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_dinning_time', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id');
            $table->unsignedInteger('dinning_time_id');
            $table->timestamps();

             $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');

             $table->foreign('dinning_time_id')
                ->references('id')
                ->on('dinning_time')
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
        Schema::dropIfExists('goods_dinning_time');
    }
}
