<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('code');
            $table->integer('confirmed')->default(0);
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('note')->nullable();
            $table->integer('payment');
            $table->string('payment_type');
            $table->integer('user_id')->nullable();
            $table->integer('deliver')->default(0);
            $table->integer('collect')->default(0);
            $table->integer('returned')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
