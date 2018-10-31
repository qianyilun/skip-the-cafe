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
            $table->string('item')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->double('price', 15, 2)->default(0);
            $table->string('owner')->nullable();
            $table->string('taker')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamps();
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
