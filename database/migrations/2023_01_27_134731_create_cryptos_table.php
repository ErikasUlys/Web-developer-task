<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptos', function (Blueprint $table) {
            $table->id();
            $table->integer('cmc_rank');
            $table->string('title');
            $table->string('symbol');
            $table->string('price');
            $table->string('percent_change_1h');
            $table->string('percent_change_24h');
            $table->string('percent_change_7d');
            $table->string('market_cap');
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
        Schema::dropIfExists('cryptos');
    }
};
