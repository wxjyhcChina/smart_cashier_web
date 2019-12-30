<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsumeRuleDinningTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consume_rule_dinning_time', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consume_rule_id');
            $table->unsignedInteger('dinning_time_id');
            $table->timestamps();

            $table->foreign('consume_rule_id')
                ->references('id')
                ->on('consume_rules')
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
        Schema::dropIfExists('consume_rule_dinning_time');
    }
}
