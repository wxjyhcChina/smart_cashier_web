<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLabelCategoryGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_category_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('label_category_id');
            $table->unsignedInteger('goods_id');
            $table->timestamps();

            $table->foreign('label_category_id')
                ->references('id')
                ->on('label_categories')
                ->onDelete('cascade');

            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
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
        Schema::dropIfExists('label_category_goods');
    }
}
