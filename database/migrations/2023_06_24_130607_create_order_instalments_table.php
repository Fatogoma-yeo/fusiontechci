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
        Schema::create('order_instalments', function (Blueprint $table) {
            $table->id();
            $table->float( 'amount_paid', 18, 5 )->default(0);
            $table->float( 'amount_unpaid', 18, 5 )->default(0);
            $table->integer( 'order_id' )->nullable();
            $table->integer( 'payment_id' )->nullable();
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
        Schema::dropIfExists('order_instalments');
    }
};
