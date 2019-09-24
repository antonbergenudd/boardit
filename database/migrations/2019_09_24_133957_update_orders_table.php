<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('confirmed_at')->nullable();
            $table->string('delivered_at')->nullable();
            $table->integer('status')->default(1);
            $table->integer('error')->default(0);

            $table->dropColumn('returned');
            $table->dropColumn('confirmed');
            $table->dropColumn('deliver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('confirmed_at');
            $table->dropColumn('delivered_at');
            $table->dropColumn('status');
            $table->dropColumn('error');

            $table->integer('returned')->default(0);
            $table->integer('confirmed')->default(0);
            $table->integer('deliver')->default(0);
        });
    }
}
