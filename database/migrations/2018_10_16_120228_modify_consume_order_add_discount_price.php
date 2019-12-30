<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConsumeOrderAddDiscountPrice extends Migration
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
            $table->double('discount_price', 10, 2)->after('price');
            $table->double('discount', 10, 2)->nullable()->after('discount_price');
            $table->integer('goods_count')->after('discount');
            $table->string('pay_method')->default('')->change();
            $table->string('external_pay_no')->default('')->change();
            $table->unsignedInteger('dinning_time_id')->nullable()->after('restaurant_user_id');
            $table->unsignedInteger('department_id')->nullable()->after('card_id');
            $table->unsignedInteger('consume_category_id')->nullable()->after('department_id');

            $table->foreign('dinning_time_id')
                ->references('id')
                ->on('dinning_time')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
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
        Schema::table('consume_orders', function (Blueprint $table) {
            //
            $table->dropColumn('discount_price');
            $table->dropColumn('discount');
            $table->dropColumn('goods_count');
            $table->string('pay_method')->change();
            $table->string('external_pay_no')->change();
        });
    }
}
