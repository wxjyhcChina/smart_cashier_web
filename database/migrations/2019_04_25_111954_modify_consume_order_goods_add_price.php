<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConsumeOrderGoodsAddPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consume_order_goods', function (Blueprint $table) {
            //
            $table->double('price', 10, 2)->default(0)->after('label_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consume_order_goods', function (Blueprint $table) {
            //
            $table->dropColumn('price');
        });
    }
}
