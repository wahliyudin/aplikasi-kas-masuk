<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_in_id');
            $table->unsignedBigInteger('account_id');
            $table->bigInteger('nominal');

            $table->foreign('cash_in_id')->references('id')->on('cash_ins')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::dropIfExists('cash_in_details');
    }
}
