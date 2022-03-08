<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoucherIdToReservasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->unsignedInteger('voucher_id')->nullable();
            $table->unsignedInteger('harga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['voucher_id', 'harga']);
        });
    }
}
