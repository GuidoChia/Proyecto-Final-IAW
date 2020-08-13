<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwelveBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twelve_buys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('bought');
            $table->integer('returned');
            $table->integer('price');
            $table->foreignId('buy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twelve_buys');
    }
}
