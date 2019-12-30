<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConsumeOrdersAddForceDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consume_orders', function (Blueprint $table) {
            //
            $table->double('force_discount', 10, 2)->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consume_orders', function (Blueprint $table) {
            //
            $table->dropColumn('force_discount');
        });
    }
}
