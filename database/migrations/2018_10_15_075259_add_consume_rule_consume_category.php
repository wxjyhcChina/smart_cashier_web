<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsumeRuleConsumeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consume_rule_consume_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consume_rule_id');
            $table->unsignedInteger('consume_category_id');
            $table->timestamps();

            $table->foreign('consume_rule_id')
                ->references('id')
                ->on('consume_rules')
                ->onDelete('cascade');

            $table->foreign('consume_category_id')
                ->references('id')
                ->on('consume_categories')
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
        Schema::dropIfExists('consume_rule_consume_category');
    }
}
