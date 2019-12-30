<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLabelCategoriesGoodIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('label_categories', function (Blueprint $table) {
            //
            $table->dropForeign('label_categories_goods_id_foreign');
            $table->dropColumn('goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('label_categories', function (Blueprint $table) {
            //
            $table->unsignedInteger('goods_id')->nullable()->after('restaurant_id');

            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');
        });
    }
}
