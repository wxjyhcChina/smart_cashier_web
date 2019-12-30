<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLabelCategoriesTable extends Migration
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
            $table->unsignedInteger('restaurant_id')->nullable()->after('id');
            $table->unsignedInteger('goods_id')->nullable()->after('restaurant_id');

            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
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
        Schema::table('label_categories', function (Blueprint $table) {
            //
            $table->dropColumn('restaurant_id');
            $table->dropColumn('goods_id');
        });
    }
}
