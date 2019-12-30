<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDinningTimeAddEnabled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dinning_time', function (Blueprint $table) {
            //
            $table->boolean('enabled')->default(true)->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dinning_time', function (Blueprint $table) {
            //
            $table->dropColumn('enabled');
        });
    }
}
