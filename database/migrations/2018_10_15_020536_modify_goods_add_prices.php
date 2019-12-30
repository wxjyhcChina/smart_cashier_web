<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGoodsAddPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            //
            $table->softDeletes();
            $table->unsignedInteger('shop_id')->nullable()->after('restaurant_id');
            $table->unsignedInteger('dinning_time_id')->nullable()->after('shop_id');
            $table->double('price', 10, 2)->after('name');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
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
        Schema::table('goods', function (Blueprint $table) {
            //
            $table->dropColumn('shop_id');
            $table->dropColumn('dinning_time_id');
            $table->dropColumn('price');
            $table->dropColumn('deleted_at');
        });
    }
}
