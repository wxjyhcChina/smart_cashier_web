<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveGoodsDinningTimeId extends Migration
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
            $table->dropForeign('goods_dinning_time_id_foreign');
            $table->dropColumn('dinning_time_id');
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
            $table->unsignedInteger('dinning_time_id')->nullable()->after('shop_id');

            $table->foreign('dinning_time_id')
                ->references('id')
                ->on('dinning_time')
                ->onDelete('cascade');
        });
    }
}
