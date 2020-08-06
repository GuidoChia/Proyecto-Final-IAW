<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->float('paid');
            $table->foreignId('user_id');
            $table->foreignId('twelve_buy_id');
            $table->foreignId('twenty_buy_id');
            $table->foreignId('extra_buy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys');
    }
}
