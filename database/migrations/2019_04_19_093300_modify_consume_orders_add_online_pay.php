<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConsumeOrdersAddOnlinePay extends Migration
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
            $table->tinyInteger('online_pay')->nullable()->after('pay_method');
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
            $table->dropColumn('online_pay');
        });
    }
}
